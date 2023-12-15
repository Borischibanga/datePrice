<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Date Range Picker Example</title>
  <!-- Include jQuery, moment.js, and daterangepicker -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
  <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
</head>
<body>
<form action="{{ route('submit-form') }}" method="post">
    @csrf <!-- Add the CSRF token field -->
    @method('POST')

    <label for="dateRange">Date Range:</label>
    <input type="text" id="dateRange" name="dateRange">
    <label for="price">Price:</label>
    <input type="number" id="price" name="price">

    <button type="submit">Submit</button>
  </form>
  <script>
    $(function() {
      // Initialize daterangepicker
      $('#dateRange').daterangepicker({
        opens: 'left', // or 'right'
        locale: {
          format: 'MM/DD/YYYY'
        }
      }, function(start, end, label) {
        // Callback function when the date range is selected
        const daysDifference = end.diff(start, 'days');
        const price = $('#price').val(); // Get the price from the input field

        console.log(`Selected date range: ${start.format('MM/DD/YYYY')} to ${end.format('MM/DD/YYYY')}`);
        console.log(`The difference between the selected dates is ${daysDifference} days.`);
        console.log(`Selected price: ${price}`);
      });

      // Update prices when applying the date range
      $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
        const start = picker.startDate.format('MM/DD/YYYY');
        const end = picker.endDate.format('MM/DD/YYYY');
        const price = $('#price').val();

        console.log(`Applying date range: ${start} to ${end}`);
        console.log(`Updated price: ${price}`);
        // You can update the UI or perform other actions based on the selected date range and price.
      });
    });
  </script>
  <a href="{{route('your-view')}}">View</a>
</body>
</html>

<!-- ... (remaining HTML code) ... -->
