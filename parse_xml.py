#!/usr/bin/python3

import xml.etree.ElementTree as Etree

root = Etree.parse('old_database.xml').getroot()

nums = []

count = 0;
for records in root:
    for record in records:
        for element in record:
            if element.tag == 'foreign-keys':
                for part in element:
                    nums.append(int(part.text))

        count += 1

nums.sort()

print("\n\n")
print("Missing entries between 1 and " + str(max(nums))  + ":")
for i in range(1,max(nums)):
    if i not in nums:
        print(i)

print("\n")
print(str(count) + " Entries found in DB file")
