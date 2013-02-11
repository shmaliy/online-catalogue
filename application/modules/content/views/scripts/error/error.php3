<div class="error_page">
	<div>
		<span class="error_page_code">
			<?php echo $this->code ? $this->code : ($this->code = 500); ?>
		</span>
		<span class="error_page_name">
			<?php 
				if ($this->code == 404) {
					if ($this->language == 'en') {
						echo 'Page not found';
					} else {
						echo 'Страница не найдена';
					}
				} else {
					if ($this->language == 'en') {
						echo 'Server internal error';
					} else {
						echo 'Внутренняя ошибка сервера';
					}
				}
			?>
		</span>
	</div>
	<?php if (isset($this->exception)): ?>
	<div class="error_page_exception">
		<span class="error_page_exception_message"><?php echo $this->exception->getMessage() ?></span>
		<div class="error_page_exception_stack_title">Stack trace:</div>
	    <ol class="error_page_exception_stack_list">
    	<?php $trace = $this->exception->getTrace(); ?>
		<?php foreach ($trace as $line): ?>
    		<li>
    			<span class="error_page_exception_stack_list_function">
    				<?php
    				echo $line['class'];
    				echo $line['type'];
    				echo $line['function'];
    				echo '(';
    				$args = array();
    				foreach ($line['args'] as $arg) {
    					if (is_object($arg)) {
    						$args[] = 'Object(' . get_class($arg) . ')';
    					} else if (is_string($arg)){
    						$args[] = "'" . $arg . "'";
    					} else if (is_array($arg)){
    						$args[] = "Array()";
    					} else {
    						$args[] = (string) $arg;
    					}
    				}
    				echo implode(', ', $args);
    				echo ')';
    				?>
    			</span>
    			<span class="error_page_exception_stack_list_file">
    				<?php 
    				echo $line['file'] . ' (' . $line['line'] . ')';
    				?>
    			</span>
    		</li>
    	<?php endforeach; ?>
		</ol>
		<div class="error_page_exception_stack_title">Request Parameters:</div>
        <div class="error_page_exception_request">
            <pre><?php echo var_export($this->request->getParams(), true); ?></pre>
        </div>
	</div>
	<?php endif; ?>
</div>
