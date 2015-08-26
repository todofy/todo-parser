###CLI Tool

**Desc:** Script to test the parsed output of any todo comment using CLI

**Usage:** `php <script-path> <todo-string>`

**Example**
```sh
php ./cli/index.php "@todo - make this function more structred and compact and nice @deadline - 22 week @tags - abhinavdahiya, dhruvagarwal, omerjerk"
```

**Output format:**
```
object(parser)#1 (18) {
  ["raw":"parser":private]=>
  string(5) " @end"
  ["todo"]=>
  string(54) "make this function more structred and compact and nice"
  ["deadline"]=>
  int(1451034066)
  ["deadline_text"]=>
  string(7) "22 week"
  ["reminder"]=>
  int(-1)
  ["reminder_text"]=>
  int(-1)
  ["tags"]=>
  array(3) {
    [0]=>
    string(13) "abhinavdahiya"
    [1]=>
    string(12) "dhruvagarwal"
    [2]=>
    string(8) "omerjerk"
  }
  ["labels"]=>
  array(0) {
  }
  ["assignment"]=>
  NULL
  ["priority"]=>
  NULL
  ["identifiers"]=>
  array(2) {
    [0]=>
    string(4) "todo"
    [1]=>
    string(5) "fixme"
  }
  ["g_todo":"parser":private]=>
  string(145) "/.*?([\#\@\s*](?:todo|fixme)[\s-_.:#$!^&*\(\)]*([a-zA-Z0-9]{1}.*?))[\#\@](?:label|labels|deadline|assign|priority|reminder|remind|tags|tag|end)/i"
  ["g_deadline":"parser":private]=>
  string(128) "/.*([\#\@]deadline[\s-_.:#$!^&*]*([a-zA-Z0-9].*?))[\#\@](?:label|labels|deadline|assign|priority|reminder|remind|tags|tag|end)/i"
  ["g_reminder":"parser":private]=>
  string(123) "/.*([\#\@](?:reminder|remind)[\s-_.:#$!^&*]*([a-zA-Z0-9].*?))[\#\@](?:label|labels|deadline|assign|priority|tags|tag|end)/i"
  ["g_priority":"parser":private]=>
  string(117) "/.*([\#\@](?:priority)[\s-_.:#$!^&*]*([a-zA-Z0-9]*).*?)[\#\@](?:label|labels|deadline|assign|priority|tags|tag|end)/i"
  ["g_tags":"parser":private]=>
  string(118) "/.*([\#\@](?:tags|tag)[\s-_.:#$!^&*]*([a-zA-Z0-9].*?))[\#\@](?:label|labels|deadline|assign|priority|tags|tag|end).*/i"
  ["g_labels":"parser":private]=>
  string(122) "/.*([\#\@](?:labels|label)[\s-_.:#$!^&*]*([a-zA-Z0-9].*?))[\#\@](?:label|labels|deadline|assign|priority|tags|tag|end).*/i"
  ["g_assign":"parser":private]=>
  string(125) "/.*([\#\@](?:assigment|assign)[\s-_.:#$!^&*]*([a-zA-Z0-9]*).*?)[\#\@](?:label|labels|deadline|assign|priority|tags|tag|end)/i"
}
```

