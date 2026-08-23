<?php
require_once __DIR__ . '/../config.php';

function sendLineOAPush($message) {
    if (empty(LINE_CHANNEL_ACCESS_TOKEN) || LINE_CHANNEL_ACCESS_TOKEN === 'YOUR_CHANNEL_ACCESS_TOKEN_HERE') return;
    if (empty(LINE_TARGET_ID) || LINE_TARGET_ID === 'YOUR_GROUP_OR_USER_ID_HERE') return;

    $url = "https://api.line.me/v2/bot/message/push";
    $data = [
        "to" => LINE_TARGET_ID,
        "messages" => [
            [
                "type" => "text",
                "text" => $message
            ]
        ]
    ];
    $post_data = json_encode($data);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . LINE_CHANNEL_ACCESS_TOKEN
    ]);
    
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

try {
    // Count total registrations
    $stmt = $pdo->query("SELECT COUNT(id) FROM registrations");
    $total_reg = $stmt->fetchColumn();

    // Count checked in
    $stmt = $pdo->query("SELECT COUNT(id) FROM checkins");
    $checked_in = $stmt->fetchColumn();
    
    // Count feedbacks
    $stmt = $pdo->query("SELECT COUNT(id) FROM feedbacks");
    $feedbacks = $stmt->fetchColumn();

    $time = date("H:i");
    $msg = "⏰ รายงานสถานะหน้างาน ($time)\n";
    $msg .= "✅ เช็คอินแล้ว: {$checked_in} / {$total_reg} คน\n";
    $msg .= "📝 ส่งประเมินแล้ว: {$feedbacks} คน\n";
    $msg .= "\n" . FOOTER_CREDIT;

    sendLineOAPush($msg);
    echo "Sent event day notification via LINE OA.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
