<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
$this->widget ( 'AdminHeaderWidget', array (
		'title' => '修改标题',
		'opButtons' => array (
				array (
						'url' => $backUrl,
						'type' => 'back' 
				) 
		) 
) );

echo $this->renderPartial('_form', array('model'=>$model));