<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HTML Select Dropdown Example</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 40px;
      line-height: 1.6;
    }
    .form-group {
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }
    select {
      padding: 8px 12px;
      font-size: 16px;
      border-radius: 4px;
      border: 1px solid #ccc;
    }
  </style>
</head>
<body>

  <h1>User Preference Form</h1>

  <form>
    <!-- Single Select Dropdown -->
    <div class="form-group">
      <label for="country">Choose a country:</label>
      <select id="country" name="country">
        <option value="" disabled selected>-- Select an option --</option>
        <option value="usa">United States</option>
        <option value="canada">Canada</option>
        <option value="uk">United Kingdom</option>
        <option value="australia">Australia</option>
      </select>
    </div>

    <!-- Grouped Options Dropdown -->
    <div class="form-group">
      <label for="car">Choose a vehicle category:</label>
      <select id="car" name="car">
        <optgroup label="Electric">
          <option value="tesla">Tesla Model 3</option>
          <option value="nissan_leaf">Nissan Leaf</option>
        </optgroup>
        <optgroup label="Gasoline">
          <option value="ford_mustang">Ford Mustang</option>
          <option value="toyota_corolla">Toyota Corolla</option>
        </optgroup>
      </select>
    </div>

    <button type="submit">Submit</button>
  </form>

</body>
</html>