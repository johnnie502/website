<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="panel panel-default col-md-10 col-md-offset-1">
        <div class="panel-heading">
            <h1><?php echo e($wiki->title); ?></h1>
        </div>
        <div class="panel-body">
            <div class="row">
                   <div class="col-md-6">
                    <?php $__currentLoopData = $wiki->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('wiki.categories', $category->name)); ?>"><?php echo e($category->name); ?></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $wiki)): ?>
                    <a class="pull-right" href="<?php echo e(route('wiki.edit', $wiki->id)); ?>">Edit</a>
                <?php endif; ?>
            </div>
	<?php echo app('Indal\Markdown\Parser')->parse($wiki->content); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>