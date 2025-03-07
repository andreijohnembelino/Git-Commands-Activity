<?php
session_start();
header('Content-Type: application/json');

include('../config/dbconn.php');

// Replace with your actual Gemini API key
$geminiApiKey = 'AIzaSyCTy3o5XuseEuJbK5H2EdwERmMUH6ExOEA'; // Replace it with your API KEY

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
        exit;
    }

    // Validate the input data
    if (isset($data['symptoms']) && is_array($data['symptoms']) && isset($data['explanation']) && !empty($data['explanation'])) {
        $symptoms = $data['symptoms'];
        $explanation = trim($data['explanation']);

        // Construct a well-formatted prompt
        $prompt = "Based on the following symptoms: " . implode(", ", $symptoms) . "\n";
        $prompt .= "And this explanation by a doctor/nurse: " . $explanation . "\n";
        $prompt .= "Generate a professional suggestion. The message should be clear, formal, and assistive to the doctor(use scientific name technical jargon for better undestanding of the doctor) .\n";
        $prompt .= "1. The likely diagnoses (a short list).\n";
        $prompt .= "2. Recommendations for health recovery and proper medication comsumption (clear and actionable tips list it in number order).";

        // Call the Gemini API
        $geminiResponse = getGeminiAiSuggestions($prompt, $geminiApiKey);

        if ($geminiResponse['success']) {
            echo json_encode([
                'success' => true,
                'aiSickness' => $geminiResponse['aiSickness'],
                'aiHealth' => $geminiResponse['aiHealth']
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gemini AI API call failed: ' . $geminiResponse['message']]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing required data (symptoms and explanation)']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();

// Function to call the Gemini AI API
function getGeminiAiSuggestions($prompt, $apiKey)
{
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $apiKey;

    $data = [
        'contents' => [
            ['parts' => [['text' => $prompt]]]
        ]
    ];

    $headers = [
        'Content-Type: application/json'
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        error_log("cURL Error: " . $error_msg);
        return ['success' => false, 'message' => 'cURL Error: ' . $error_msg];
    }

    curl_close($ch);

    $responseData = json_decode($response, true);

    if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
        // Split response text into diagnoses and recommendations
        $responseText = $responseData['candidates'][0]['content']['parts'][0]['text'];

        // Split the response into two parts based on the prompt structure
        $responseParts = preg_split('/\n\s*2\.\s*/', $responseText, 2);

        $aiSickness = isset($responseParts[0]) ? $responseParts[0] : "No diagnoses provided.";
        $aiHealth = isset($responseParts[1]) ? $responseParts[1] : "No recovery recommendations provided.";

        return [
            'success' => true,
            'aiSickness' => $aiSickness,
            'aiHealth' => $aiHealth
        ];
    } else {
        error_log("Gemini API response structure is incorrect: " . json_encode($responseData));
        return ['success' => false, 'message' => 'Gemini API response structure is incorrect'];
    }
}
