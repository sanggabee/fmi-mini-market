<?php echo $message; ?><br />
<script type="text/javascript">
    window.location = '<?php echo $this->createUrl('view', array('id'=>$model->id)); ?>';
</script>