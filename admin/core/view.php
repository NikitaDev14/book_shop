<?php
	class View
	{
		private $template_view = 'views/view_main.php';
		
		public function message($message = null)
		{
			include $this->template_view;
			
			echo $message;
		}
		public function form($content_view)
		{
			include $this->template_view;
			
			include 'views/'.$content_view;
		}
	}
?>