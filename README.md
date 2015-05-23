# TODO parser [![Build Status](https://travis-ci.org/TODOCI/todo-parser.svg)](https://travis-ci.org/TODOCI/todo-parser)
a parser in php that extracts structured todo information from comments


Possible todo format
```
Need to understnad this ^^ #todo - set token for this cookie @deadline : 1 week @reminder 5 days
@priority --  HIGH #tags: mebjas abhinavdahiya @assign: mebjas @label cookie, token, need_help
```

This should give
```md
TODO: 		set token for this cookie
DEADLINE: 	1 week
REMINDER: 	5 days
PRIORITY: 	high
TAGS: 		array(mebjas, abhinavdahiya)
ASSIGNMENT: mebjas
LABELS: 	array(cookie, token, need_help)
```

#CONDITIONS
 - The tokens are case insensitive
 - Tokens include: `todo` `deadline` `reminder` `remind` `priority` `tags` `tag` `assignment` `assign` `labels` `label`
 - `deadline` & `reminder` can be of format `MM-DD-YYYY` OR `MM/DD/YY` OR of kind `1 week` OR `2 days` etc
 - `priority` & `assignment` OR `assing` has to be single word or the first single word will be considered
 - `tags` & `labels` should be `space` or `comma` separated, though `comma` would be preferred
 
#BEST PRACTICES
 - Use these `todo`, `deadline`, `reminder`, `priority`, `tags`, `assignment`, `labels` in place of counterparts
 - use lesser symbols and more of alpha numeric charecters

#LICENSE
Will be added soon
