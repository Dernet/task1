<?php include ROOT . '/views/layouts/header.php'; ?>

<form action="#" method="post" class="my-5">
  <div class="form-group">
    <label>Email</label>
    <input type="email" class="form-control" disabled value="<?php echo $item['email']; ?>">
  </div>
  <div class="form-group">
    <label>Text</label>
    <textarea name="item_text" class="form-control"><?php echo $item['item_text']; ?></textarea>
  </div>
  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" name="status" id="exampleCheck1"
    
        <?php if($item['status']): ?>
            checked
        <?php endif; ?>

    >
    
    <label class="form-check-label" for="exampleCheck1">Выполнен</label>
  </div>
  <button type="submit" name="submit" class="btn btn-primary">Подтвердить</button>
</form>

<?php include ROOT . '/views/layouts/footer.php'; ?>