<?php
/**
 * @library - deals with parsing todo comments
 * @dependencies - none
 */

if (!isset($_LIB_TODO_PARSER)) {
	$_LIB_TODO_PARSER = true;
	// ^ to avoid multiple redeclarations

	class parser {
		private $raw;

		public $todo;
		public $deadline;
		public $reminder;
		public $tags;
		public $labels;
		public $assignment;
		public $priority;

		private $g_todo = '/.*([\#\@]todo[\s-_.:#$!^&*]*([a-zA-Z0-9]{1}.*?))[\#\@](?:label|labels|deadline|assign|priority|reminder|remind|tags|tag|end)/i';

		private $g_deadline = '/.*([\#\@]deadline[\s-_.:#$!^&*]*([a-zA-Z0-9].*?))[\#\@](?:label|labels|deadline|assign|priority|reminder|remind|tags|tag|end)/i';

		private $g_reminder = '/.*([\#\@](?:reminder|remind)[\s-_.:#$!^&*]*([a-zA-Z0-9].*?))[\#\@](?:label|labels|deadline|assign|priority|tags|tag|end)/i';

		private $g_priority = '/.*([\#\@](?:priority)[\s-_.:#$!^&*]*([a-zA-Z0-9]*).*?)[\#\@](?:label|labels|deadline|assign|priority|tags|tag|end)/i';

		// #todo - add tagging by email id too later
		private $g_tags = '/.*([\#\@](?:tags|tag)[\s-_.:#$!^&*]*([a-zA-Z0-9].*?))[\#\@](?:label|labels|deadline|assign|priority|tags|tag|end).*/i';

		private $g_labels = '/.*([\#\@](?:labels|label)[\s-_.:#$!^&*]*([a-zA-Z0-9].*?))[\#\@](?:label|labels|deadline|assign|priority|tags|tag|end).*/i';

		private $g_assign = '/.*([\#\@](?:assigment|assign)[\s-_.:#$!^&*]*([a-zA-Z0-9]*).*?)[\#\@](?:label|labels|deadline|assign|priority|tags|tag|end)/i';

		/**
		 * Constructor function
		 * @param: (string) $todo string the whole comment
		 */
		function __construct($todo) {
			$this->raw = $todo .'@end';

			// Attempt to extract todo text from the raw first
			// Since the parser is called its supposed to have
			// TODO (Case Insensitive TEXT in it)
			preg_match($this->g_todo, $this->raw, $matches);

			if (isset($matches[2])) $this->todo = $this->trim($matches[2]);
			else $this->todo = '[todo string missing] set manually!';

			if (isset($matches[1])) {
				$this->raw = str_replace($matches[1], '', $this->raw);
			}

			// Extract deadline from the comment
			// There is possiblity that you'd not find any deadline
			// in that case set deadline as -1
			preg_match($this->g_deadline, $this->raw, $matches);
			if (isset($matches[2])) $this->deadline = $this->trim($matches[2]);
			else $this->deadline = -1;

			if ($this->deadline != -1) {
				// #todo - make this more fine, test with more testcases
				$this->deadline = strtotime($this->deadline);
			}

			if (isset($matches[1])) {
				$this->raw = str_replace($matches[1], '', $this->raw);
			}

			// Extract reminder from the comment
			// There is possiblity that you'd not find any reminder
			// in that case set reminder as -1
			preg_match($this->g_reminder, $this->raw, $matches);
			if (isset($matches[2])) $this->reminder = $this->trim($matches[2]);
			else $this->reminder = -1;

			if ($this->reminder != -1) {
				// #todo - make this more fine, test with more testcases
				// for dates it takes format like MM/DD/YYYY
				// test permutations here?
				$this->reminder = strtotime($this->reminder);
			}

			if (isset($matches[1])) {
				$this->raw = str_replace($matches[1], '', $this->raw);
			}

			// Extract priority from the comment
			// There is possiblity that you'd not find any priority
			preg_match($this->g_priority, $this->raw, $matches);
			if (isset($matches[2])) $this->priority = strtolower($this->trim($matches[2]));
			else $this->priority = NULL;

			if (isset($matches[1])) {
				$this->raw = str_replace($matches[1], '', $this->raw);
			}

			// Extract tgs from the comment
			// There is possiblity that you'd not find any tags
			preg_match($this->g_tags, $this->raw, $matches);
			$this->tags = array();
			if (isset($matches[2])) {
				$tmp = $this->trim($matches[2]);
				$tmp = str_replace(' ', ',', $tmp);
				while(strpos($tmp, ',,') !== false) $tmp = str_replace(',,', ',', $tmp);
				$tmp = explode(',', $tmp);
				$i = 0;
				foreach ($tmp as $key => $value) {
					if (strlen(trim($value))) $this->tags[$i++] = trim($value);
				}
			}

			if (isset($matches[1])) {
				$this->raw = str_replace($matches[1], '', $this->raw);
			}

			// Extract labels from the comment
			// There is possiblity that you'd not find any deadline
			preg_match($this->g_labels, $this->raw, $matches);
			$this->labels = array();
			if (isset($matches[2])) {
				$tmp = $this->trim($matches[2]);
				$tmp = str_replace(' ', ',', $tmp);
				while(strpos($tmp, ',,') !== false) $tmp = str_replace(',,', ',', $tmp);
				$tmp = explode(',', $tmp);
				$i = 0;
				foreach ($tmp as $key => $value) {
					if (strlen(trim($value))) $this->labels[$i++] = trim($value);
				}
			}

			if (isset($matches[1])) {
				$this->raw = str_replace($matches[1], '', $this->raw);
			}

			// Extract assignment from the comment
			// There is possiblity that you'd not find any priority
			preg_match($this->g_assign, $this->raw, $matches);
			if (isset($matches[2])) $this->assignment = strtolower($this->trim($matches[2]));
			else $this->assignment = NULL;

			if (isset($matches[1])) {
				$this->raw = str_replace($matches[1], '', $this->raw);
			}


		}

		private function trim($str) {
			while(strpos($str, '  ') !== false) {
				$str = str_replace('  ', ' ', $str);
			}

			return trim($str);			
		}
	};

};