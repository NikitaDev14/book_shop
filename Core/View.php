<?php
	namespace Core;
	class View
	{
		public function generate($content_view, $message = null)
		{
			include 'views/'.$content_view;
			echo $message;
		}
	}
?>