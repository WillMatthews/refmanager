#!/usr/bin/python3

# script to parse an EndNote XML database file, and populate a mysql database with the contents

import xml.etree.ElementTree as Etree
import pymysql
#from termcolor import colored

nums = []
count = 0;
dictList = []
stdDict = {"title":"","author":"","key":"","year":"","abstract":"","keywords":"","volume":"","number":"","pages":"","url":"","comments":""}

root = Etree.parse('old_database.xml').getroot()

for records in root:
    for record in records:
        newdict = stdDict.copy()

        #print("\n\n")
        for element in record:
            #print(element.tag)
            workingtext = ""
            ispresent = False

            #print(colored(element.tag,"green"))
            #if element.text is not None:
            #    print("    " + element.text)

            for part in element:
                if part.text is not None:
                    title = element.tag
                    workingtext += part.text + " "
                    ispresent = True

                else:
                    for subpart in part:

                        #print(colored(subpart.tag,"blue"))
                        if subpart.text is not None:
                            title = part.tag
                            workingtext += subpart.text + " "
                            ispresent = True
                        else:
                            for subsubpart in subpart:
                                title = subpart.tag
                                workingtext += subsubpart.text + " "
                                ispresent = True

            if ispresent:
                if title == "secondary-title":
                    title = "title"
                elif title == "foreign-keys":
                    title = "key"
                elif title == "keyword":
                    title = "keywords"


                #print(colored(title,"red"))
                #print("     " + workingtext)

                newdict[title] = workingtext.replace("\r","\n").strip()

        count += 1


        dictList.append(newdict)


for d in dictList:
    print(d)
    print("\n\n")
    d["key"] = int(d["key"])
    nums.append(d["key"])


nums.sort()

print("\n\n")
print("Missing entries between 1 and " + str(max(nums))  + ":")
for i in range(1,max(nums)):
    if i not in nums:
        print(i)

print("\n")
print(str(count) + " Entries found in DB file")

conn = pymysql.connect(host='localhost', user="will", passwd="will", db='agricoat', charset = 'utf8mb4', cursorclass=pymysql.cursors.DictCursor)

cur = conn.cursor()

sql = """INSERT INTO library (`title`, `author`, `key`, `year`, `abstract`, `keywords`, `volume`, `number`, `pages`, `url`, `comments`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s);"""
count2 = 0
for d in dictList:
	cur.execute(sql,(d["title"],d["author"],d["key"],d["year"],d["abstract"],d["keywords"],d["volume"],d["number"],d["pages"],d["url"],d["comments"],))
	conn.commit()
	count2 += 1
	print("Inserted value " + str(count2) + " of: "+	str(count))


cur.close()
conn.close()
