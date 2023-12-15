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
<form action="{{ route('your-view') }}" method="Get">
    @csrf <!-- Add the CSRF token field -->
    @method('get')

    <label for="dateRange">Date Range:</label>
    <input type="text" id="dateRange" name="dateRange">
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
            console.log(`Selected date range: ${start.format('MM/DD/YYYY')} to ${end.format('MM/DD/YYYY')}`);
            console.log(`The difference between the selected dates is ${daysDifference} days.`);
        });

        // Update prices when applying the date range
        $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
            const start = picker.startDate.format('MM/DD/YYYY');
            const end = picker.endDate.format('MM/DD/YYYY');

            console.log(`Applying date range: ${start} to ${end}`);

            // Fetch prices from the server for the selected date range
            $.ajax({
                url: '/fetch-prices',
                type: 'GET',
                data: {
                    start: start,
                    end: end
                },
                success: function(response) {
                    // Assuming response is a JSON array of prices
                    const prices = JSON.parse(response);

                    // Update the calendar with prices
                    updateCalendar(prices);
                },
                error: function(error) {
                    console.error('Error fetching prices:', error);
                }
            });
        });

        // Function to update the calendar with prices
        function updateCalendar(prices) {
            // Destroy the existing calendar instance
            $('#dateRange').daterangepicker('destroy');

            // Reinitialize the calendar
            $('#dateRange').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'MM/DD/YYYY'
                },
                isInvalidDate: function(date) {
                    // Check if the date has a corresponding price
                    const formattedDate = date.format('MM/DD/YYYY');
                    const hasPrice = prices.some(price => price.date === formattedDate);
                    return !hasPrice;
                },
                showCustomRangeLabel: false,
                isCustomDate: function(date) {
                    // Customize the appearance of dates with prices
                    const formattedDate = date.format('MM/DD/YYYY');
                    const price = prices.find(price => price.date === formattedDate);

                    if (price) {
                        // You can customize the appearance here (e.g., change the background color)
                        return 'has-price';
                    }

                    return false;
                }
            });
        }
    });
</script>
</body>
</html>
