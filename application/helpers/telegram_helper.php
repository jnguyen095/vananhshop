<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('send_telegram')) {

	/**
	 * Send message to Telegram
	 *
	 * @param string $message
	 * @param string|null $token
	 * @param string|null $chatId
	 * @return array
	 */
	function send_telegram($message, $token = null, $chatId = null)
	{
		if (!$token) {
			$token = TELEGRAM_BOT_TOKEN; //getenv('TELEGRAM_BOT_TOKEN');
		}

		if (!$chatId) {
			$chatId = TELEGRAM_CHAT_ID;//getenv('TELEGRAM_CHAT_ID');
		}

		if (empty($token) || empty($chatId)) {
			return [
				'success' => false,
				'message' => 'Telegram token or chat id missing'
			];
		}

		$url = "https://api.telegram.org/bot{$token}/sendMessage";

		$payload = [
			'chat_id'    => $chatId,
			'text'       => $message,
			'parse_mode' => 'HTML'
		];

		$ch = curl_init();

		curl_setopt_array($ch, [
			CURLOPT_URL            => $url,
			CURLOPT_POST           => true,
			CURLOPT_POSTFIELDS     => http_build_query($payload),
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT        => 15,
			CURLOPT_SSL_VERIFYPEER => true,
		]);

		$response = curl_exec($ch);
		$error    = curl_error($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

		if ($error) {
			return [
				'success' => false,
				'message' => $error
			];
		}

		return [
			'success'   => ($httpCode == 200),
			'http_code' => $httpCode,
			'response'  => json_decode($response, true)
		];
	}
}

if (!function_exists('notify_new_order')) {
	function notify_new_order($order)
	{
		$message = "🛒 <b>ĐƠN HÀNG MỚI</b>\n\n";
		$message .= "Mã đơn: {$order['order_code']}\n";
		$message .= "Khách hàng: {$order['customer_name']}\n";
		$message .= "Điện thoại: {$order['phone']}\n";
		$message .= "Tổng tiền: " . number_format($order['total']) . "đ\n\n";
		$message .= "⏰ Thời gian: " . date('d/m/Y H:i');

		return send_telegram($message);
	}
}



