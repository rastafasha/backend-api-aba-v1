<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class ClaimMdService
{
    private string $baseUrl;
    private string $accountKey;

    public function __construct()
    {
        $this->baseUrl = config('services.claimmd.url', 'https://svc.claim.md/services/upload/');
        $this->accountKey = config('services.claimmd.account_key');
    }

    /**
     * Send EDI X12 file to Claim.md
     *
     * @param string $fileContent The EDI X12 file content
     * @param string $filename The name of the file
     * @return array
     * @throws Exception
     */
    public function sendEdiFile(string $fileContent, string $filename): array
    {
        try {
            $response = Http::asMultipart()
                ->accept('application/xml')
                ->post($this->baseUrl, [
                    'AccountKey' => $this->accountKey,
                    'File' => $fileContent,
                    'Filename' => $filename,
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json() ?? $response->body(),
                ];
            }

            throw new Exception('Failed to send EDI file: ' . $response->body());
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
}
