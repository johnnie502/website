<div class="col-md-3 side-bar">
  <div class="panel panel-default corner-radius">
    <?php if(isset($node)): ?>
      <div class="panel-heading text-center">
        <h3 class="panel-title"><?php echo e($node->name); ?></h3>
      </div>
    <?php endif; ?>
    <div class="panel-body text-center">
      <div class="btn-group">
        <a href="<?php echo e(URL::route('topics.create')); ?>" class="btn btn-success btn-lg">发帖</a>
      </div>
    </div>
  </div>
<?php if(Route::currentRouteName() == 'topics'): ?>
  <div class="panel panel-default corner-radius">
    <div class="panel-heading text-center">
      <h3 class="panel-title"></h3>
    </div>
    <div class="panel-body text-center" style="padding: 7px;">
      <a href="https://phphub.org/topics/1531" target="_blank" rel="nofollow" title="">
        <img src="https://dn-phphub.qbox.me/uploads/images/201512/08/1/cziZFHqkm8.png" style="width:240px;">
      </a>
    </div>
  </div>
<?php endif; ?>
  <div class="panel panel-default corner-radius">
    <div class="panel-heading text-center">
      <h3 class="panel-title"></h3>
    </div>
    <div class="panel-body">
      <ul class="list">
      </ul>
    </div>
  </div>
  <div class="panel panel-default corner-radius">
    <div class="panel-heading text-center">
      <h3 class="panel-title"></h3>
    </div>
  </div>
  </div>

  <div class="panel panel-default corner-radius">
    <div class="panel-heading text-center">
      <h3 class="panel-title"></h3>
    </div>
    <div class="panel-body">
      <ul class="list">
      </ul>
    </div>
  </div>
  <?php if(isset($links) && count($links)): ?>
    <div class="panel panel-default corner-radius">
      <div class="panel-heading text-center">
        <h3 class="panel-title"><?php echo e('友情链接'); ?></h3>
      </div>
      <div class="panel-body text-center" style="padding-top: 5px;">
        <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e($link->link); ?>" target="_blank" rel="nofollow" title="<?php echo e($link->title); ?>">
                <img src="<?php echo e($link->cover); ?>" style="width:150px; margin: 3px 0;">
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  <?php endif; ?>
  <?php if(isset($nodeTopics) && count($nodeTopics)): ?>
    <div class="panel panel-default corner-radius">
      <div class="panel-heading text-center">
        <h3 class="panel-title"><?php echo e('同节点帖子'); ?></h3>
      </div>
      <div class="panel-body">
        <ul class="list">
          <?php $__currentLoopData = $nodeTopics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nodeTopic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
            <a href="<?php echo e(route('topics.show', $nodeTopic->id)); ?>">
              <?php echo e($nodeTopic->title); ?>

            </a>
            </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    </div>
  <?php endif; ?>
  <div class="panel panel-default corner-radius">
    <div class="panel-heading text-center">
      <h3 class="panel-title"><?php echo e('小贴士'); ?></h3>
    </div>
    <div class="panel-body">
      <?php echo e(''); ?>

    </div>
  </div>
    <?php if(Route::currentRouteName() == 'topics'): ?>
  <div class="panel panel-default corner-radius">
    <div class="panel-heading text-center">
      <h3 class="panel-title"></h3>
    </div>
    <div class="panel-body">
      <ul>
      </ul>
    </div>
  </div>
    <?php endif; ?>
</div>