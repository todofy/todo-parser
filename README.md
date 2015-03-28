# todo-parser
a parser in php that extracts structured todo information from comments


Possible todo format
```
Need to understnad this ^^ #todo - set token for this cookie @deadline : 1 week @reminder 5 days
@priority --  HIGH #tags: mebjas abhinavdahiya @assign: mebjas @label cookie, token, need_help
```

This should give
```
TODO: 		set token for this cookie
DEADLINE: 	1 week
REMINDER: 	5 days
PRIORITY: 	high
TAGS: 		array(mebjas, abhinavdahiya)
ASSIGNMENT: mebjas
LABELS: 	array(cookie, token, need_help)

``
