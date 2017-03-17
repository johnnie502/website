<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1></h1>
        </div>
        <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-group">
                            <?php $__currentLoopData = $wikis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wiki): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item">
                            <div class="pull-left">
                                <img alt="" src="/avatars/<?php echo e($wiki->user); ?>.png" width="32" height="32" /></span>
                            </div>
                            <a href="<?php echo e(route('wiki.show', $wiki->title)); ?>"><?php echo e($wiki->title); ?></a><br>
                            <div>
                                <a href="<?php echo e(route('users.show', $wiki->users->username)); ?>"><?php echo e($wiki->users->username); ?></a>&nbsp;•&nbsp;
                            </div>
                        </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>