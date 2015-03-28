<?php

if (!defined(_LIB_TODO_PARSER)) {
	define('_LIB_TODO_PARSER', true);
	// ^ to avoid multiple redeclarations


	class parser {
		private $raw;

		public $todo;
		public $deadline;
		public $reminder;
		public $tags;
		public $label;
		public $assignment;
		public $priority;

		/**
		 * Constructor function
		 * @param: (string) $todo string the whole comment
		 */
		function __construct($todo) {
			$this->raw = $todo;

		}
	};

};