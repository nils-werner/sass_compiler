<?php

	Class extension_SASS_Compiler extends Extension{

		public function about(){
			return array(
				'name' => 'SASS Compiler',
				'version' => '1.0',
				'release-date' => '2012-02-02',
				'author' => array(
					array(
						'name' => 'Nils Werner',
						'website' => 'http://www.obssessive-media.de/',
						'email' => 'nils.werner@gmail.com'
					)
				)
			);
		}

		public function getSubscribedDelegates(){
			return array();
		}

		public function install(){
			General::realiseDirectory(CACHE . '/sass_compiler/', Symphony::Configuration()->get('write_mode', 'directory'));
			
			$htaccess = @file_get_contents(DOCROOT . '/.htaccess');

			if($htaccess === false) return false;

			## Cannot use $1 in a preg_replace replacement string, so using a token instead
			$token = md5(time());

			$rule = "
	### SASS RULES
	RewriteRule ^sass\/(.+\.sass)\$ extensions/sass_compiler/lib/sass.php?mode=sass&param={$token} [L,NC]
	RewriteRule ^scss\/(.+\.scss)\$ extensions/sass_compiler/lib/sass.php?mode=scss&param={$token} [L,NC]\n\n";

			## Remove existing the rules
			$htaccess = self::__removeSassRules($htaccess);

			if(preg_match('/### SASS RULES/', $htaccess)){
				$htaccess = preg_replace('/### SASS RULES/', $rule, $htaccess);
			}
			else{
				$htaccess = preg_replace('/RewriteRule .\* - \[S=14\]\s*/i', "RewriteRule .* - [S=14]\n{$rule}\t", $htaccess);
			}

			## Replace the token with the real value
			$htaccess = str_replace($token, '$1', $htaccess);

			return @file_put_contents(DOCROOT . '/.htaccess', $htaccess);
		}

		public function uninstall(){
			$htaccess = @file_get_contents(DOCROOT . '/.htaccess');

			if($htaccess === false) return false;

			$htaccess = self::__removeSassRules($htaccess);
			$htaccess = preg_replace('/### SASS RULES/', NULL, $htaccess);

			return @file_put_contents(DOCROOT . '/.htaccess', $htaccess);
		}

		public function enable(){
			return $this->install();
		}

		public function disable(){
			$htaccess = @file_get_contents(DOCROOT . '/.htaccess');

			if($htaccess === false) return false;

			$htaccess = self::__removeSassRules($htaccess);
			$htaccess = preg_replace('/### SASS RULES/', NULL, $htaccess);

			return @file_put_contents(DOCROOT . '/.htaccess', $htaccess);
		}

	/*-------------------------------------------------------------------------
		Utilities:
	-------------------------------------------------------------------------*/

		private static function __removeSassRules($string){
			return preg_replace('/RewriteRule \^sass[^\r\n]+[\r\n]?/i', NULL, $string);
		}

	}
