<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyOrders</title>
</head>
<body>
    <h1>Siparişlerim</h1>
    
    @if(isset($success))
        <p>{{$success}}</p>
    @endif
    @if(isset($error))
        <p>{{$error}}</p>
    @endif
    <button style="background-color: #000; color: #fff; border-radius: 10px; padding: 10px; border: 1px solid #000; cursor: pointer;" onclick="window.location.href='/main'">Ana Sayfaya Dön</button> <br> <br>
    @if(empty($orders))
        <strong>Siparişiniz yok</strong> <br> <br>
    @else
        @foreach($orders as $order)
            <div style="margin-bottom: 30px; border: 1px solid #000; padding: 10px; border-radius: 10px;">
                <br>
                <table border="5" cellpadding="8" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Ürün</th>
                            <th>Kategori Adı</th>
                            <th>Yazar</th>
                            <th>Ürün Sayısı</th>
                            <th>Fiyat</th>
                            <th>Toplam Fiyat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->title }}</td>
                            <td>{{ $item->product->category?->category_title }}</td>
                            <td>{{ $item->product->author }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->product->list_price }}</td>
                            <td>{{ $item->product->list_price * $item->quantity }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                <label>Sipariş No: </label>{{ $order->id }}<br>
                <label>Sipariş Tarihi: </label>{{ $order->created_at }}<br>
                <label>Durum: </label>{{ $order->status }}<br>
                <label>Kargo Fiyatı: </label>{{ $order->cargo_price == 0 ? "Kargo Ücretsiz" : $order->cargo_price }}<br>
                <label>Kampanya: </label> {{$order->campaign_info ?? "Kampanya Yok"}} <br>
                <label>İndirim Tutarı: </label>{{ $order->discount }}<br>
                <strong>Toplam Fiyat: </strong>{{ $order->price }}<br>
                <strong>İndirimli Fiyatı: </strong>{{ $order->campaing_price }}<br>
                <br>
                <form action="{{route('myorders.delete', $order->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background-color: #000; color: #fff; border-radius: 10px; padding: 10px; border: 1px solid #000; cursor: pointer;">Siparişi İptal Et</button>
                </form>
            </div>
        @endforeach
    @endif
    
</body>
</html>