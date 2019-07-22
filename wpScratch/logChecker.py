import sys
import fileinput
import os
import re
import collections
from collections import Counter
import smtplib
from email.mime.multipart import MIMEMultipart
from email.MIMEText import MIMEText
import time
import requests
import json

RUNCHECKFILE = '/tmp/checker'
MAXHIT_THRESHOLD = 100
BLOCK_THRESHOLD = 1200


def processLogForIP(filename):
        ipResultList = []
        with open(filename) as f:
                for line in f:
                        ipMatch = re.search('\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}', line)
                        if ipMatch:
                                ipResultList.append(ipMatch.group(0))
        ipCounts = Counter(ipResultList)
        top5IP =  dict(ipCounts.most_common(5))
        # aka I can't remember how this works. There's probably a better way of doing this but...
        worstOffendingIP = dict(ipCounts.most_common(1)).keys()[0]
        maxHitsIP = max(top5IP.values())
        return top5IP, maxHitsIP, worstOffendingIP

def geoIPLoookup(ipAddress):
        url = "http://ip-api.com/json/" + ipAddress
        r = requests.get(url)
        # print r.text
        return r.text

def processLogForLogins(filename):
        loginResultList = []
        with open(filename) as f:
                for line in f:
                        loginMatch = re.search('(.)*wp-login.php(.)*',line)
                        if loginMatch:
                                ipForLoginMatch = re.search('\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}', line)
                                loginResultList.append(ipForLoginMatch.group(0))
        loginCounts = Counter(loginResultList)
        top5Login = dict(loginCounts.most_common(5))
        return top5Login

def emailHitMax(top5Login, maxHits, jsonFromGeoip, blockedMax, worstOffendingIP):
        msg = MIMEMultipart()
        msg['From'] = "donal@the-plot.com"
        msg['To'] = "donal@the-plot.com"
        msg['Subject'] = "something going on..."
        body = "max hits is " + str(maxHits) + " with top 5: \n" + str(top5Login) + "\nResponse from GeoIP service for worst offending IP:\n" + jsonFromGeoip.encode("ascii","ignore")
        if blockedMax is True:
                body = body + "\nBlock threshold exceeded so " + (worstOffendingIP.encode("utf-8")) + " has been blocked"
        msg.attach(MIMEText(body, 'plain'))

        server = smtplib.SMTP('the-plot.com', 25)
        server.starttls()
        server.login("donal", "*** actual password needs to go here ***")

        text = msg.as_string()
        server.sendmail("donal@the-plot.com", "donal@the-plot.com", text)
        server.quit()


def hitMaxTodayAready():
        #print "up here"
        if not os.path.exists(RUNCHECKFILE):
                fo = open(RUNCHECKFILE, 'a')
                fo.write(time.strftime("%d/%m/%Y"))
                fo.close()
                return False
        else:
                fo = open(RUNCHECKFILE, 'r+')
                lastHitDate = fo.read();
                stringToday = time.strftime("%d/%m/%Y")
                if lastHitDate == stringToday:
                        #print "been there done that"
                        return True
                else:
                        #print "looks like yesterday to me"
                        fo.seek(0)
                        fo.write(stringToday)
                        fo.truncate()
                        fo.close()
                        return False

def blockMax(worstOffendingIP):
        ranges = worstOffendingIP.split(".")
        cidr = ranges[0]+"."+ranges[1]
        stringForBlockCmd = "/sbin/iptables -A INPUT -s " + cidr + ".0.0/16 -j DROP"
        #print(stringForBlockCmd)
        os.system(stringForBlockCmd)

blockedMax = False
filename = sys.argv[1]
if not os.path.exists(filename):
        print("no file!")
        sys.exit(0)
if len(sys.argv) == 3:
        if sys.argv[2] == "logins":
                print("top 5 login attempts: " + str(processLogForLogins(filename)))
                sys.exit(0)


top5IP, maxHits, worstOffendingIP = processLogForIP(filename)
# print top5IP, maxHits, worstOffendingIP
jsonFromGeoip = geoIPLoookup(str(worstOffendingIP))


if maxHits > MAXHIT_THRESHOLD:
        if not hitMaxTodayAready():
                if maxHits >= BLOCK_THRESHOLD:
                        #print("true")
                        blockMax(worstOffendingIP)
                        blockedMax = True
                emailHitMax(top5IP, maxHits, jsonFromGeoip, blockedMax, worstOffendingIP)

