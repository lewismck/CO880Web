# Fill in the lists and run to generate insert statements for the KB

# Inserts for the character table
character_list = '''Bobby,Briggs,M
fname1,lname1,gender1'''.split('\n')

# Inserts for the character_desc table
character_desc = '''22,Son of Major Briggs
12,temperment1'''.split('\n')


print('\nCHARACTER DESC\n')
#Return insert statements for character_desc
for i in character_desc:
  B = i.split(',')
  print('''INSERT INTO character_desc (age, temperment) VALUES(%s, '%s');''' %(B[0], B[1]))

print('CHARACTERS\n')
#Return insert statements for the character_list
for i in character_list:
 	B = i.split(',')
 	print('''INSERT INTO s_character (fname, lname, gender, c_desc) VALUES('%s', '%s', '%s', (SELECT MAX(desc_id) FROM character_desc));''' %(B[0], B[1], B[2]))

# Inserts for the locations table
locations = '''the Town Hall-gathering place for bake sales and local politics-wood and plastic panelled building, with creaky chairs and folding tables inside
name1-brief1-long_desc1'''.split('\n')

print('\nLOCATIONS\n')
for i in locations:
  B = i.split('-')
  print('''INSERT INTO location (name, brief, long_desc) VALUES('%s', '%s', '%s');''' %(B[0], B[1], B[2]))

# Inserts for the events table
events = '''A storm looms on the horizon-black clouds and lightening can be seen in the distance, heading towards town-ominous
brief1-long_desc1-tone1'''.split('\n')

print('\nEVENTS\n')
for i in events:
  B = i.split('-')
  print('''INSERT INTO event (brief, long_desc, tone) VALUES('%s', '%s', '%s');''' %(B[0], B[1], B[2]))

# Event Consequences
event_consequences = '''the storm arrives, bringing hammering rain and deafening thunder-thunder and lightening deafen and blind the residents who look into the storm-scary
brief1-long_desc1-tone1'''.split('\n')

print('\nEVENT CONSEQUENCES\n')
for i in event_consequences:
  B = i.split('-')
  print('''INSERT INTO event_consequence (brief, long_desc, tone, event_id) VALUES('%s', '%s', '%s', (SELECT MAX(event_id) FROM event));''' %(B[0], B[1], B[2]))


# Actions
actions = '''goes exploring in the woods-heads into the woods in a spirit of adventure-exciting
brief1-long_desc1-tone1'''.split('\n')
print('\nACTIONS\n')
for i in actions:
  B = i.split('-')
  print('''INSERT INTO action (brief, long_desc, tone) VALUES('%s', '%s', '%s');''' %(B[0], B[1], B[2]))

# Event Consequences
action_consequences = '''brief-long_desc-tone
brief1-long_desc1-tone1'''.split('\n')

print('\nACTION CONSEQUENCES\n')
for i in action_consequences:
  B = i.split('-')
  print('''INSERT INTO action_consequence (brief, long_desc, tone, ac_id) VALUES('%s', '%s', '%s', (SELECT MAX(ac_id) FROM action);''' %(B[0], B[1], B[2]))
