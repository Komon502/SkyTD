<!-- trade.php: หน้าทำรายการเทรด -->
<form method="post" action="/trade">
    <select name="forex_pair">
        <option value="EURUSD">EUR/USD</option>
        <option value="USDJPY">USD/JPY</option>
    </select>
    <input type="number" name="amount" placeholder="Amount" required />
    <select name="direction">
        <option value="up">ขึ้น</option>
        <option value="down">ลง</option>
    </select>
    <select name="mode">
        <option value="demo">Demo</option>
        <option value="real">Real</option>
    </select>
    <button type="submit">Trade</button>
</form>
