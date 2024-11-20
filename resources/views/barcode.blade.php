<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sortable Categories</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }
    #categories {
      border: 1px solid #ddd;
      padding: 10px;
      border-radius: 5px;
      background-color: #f9f9f9;
    }
    .category, .child-category {
      padding: 8px 12px;
      margin: 5px 0;
      border: 1px solid #ccc;
      border-radius: 3px;
      background-color: #fff;
      cursor: grab;
    }
    .child-categories {
      margin-left: 20px;
    }
  </style>
</head>
<body>
  <h1>Sortable Categories</h1>
  <div id="categories">
    <div class="category" data-id="1">
      Category 1
      <div class="child-categories">
        <div class="child-category" data-id="1.1">Child Category 1</div>
      </div>
    </div>
    <div class="category" data-id="2">
      Category 2
      <div class="child-categories">
        <div class="child-category" data-id="2.1">Child Category 2</div>
        <div class="child-category" data-id="2.2">Child Category 3</div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
  <script>
    // Enable sorting for main categories
    new Sortable(document.getElementById('categories'), {
      animation: 150,
      handle: '.category',
      draggable: '.category',
    });

    // Enable sorting for child categories within each category
    document.querySelectorAll('.child-categories').forEach(container => {
      new Sortable(container, {
        animation: 150,
        draggable: '.child-category',
      });
    });
  </script>
</body>
</html>
