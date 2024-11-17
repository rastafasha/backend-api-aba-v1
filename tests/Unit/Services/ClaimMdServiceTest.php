<?php

namespace Tests\Unit\Services;

use App\Services\ClaimMdService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ClaimMdServiceTest extends TestCase
{
    private ClaimMdService $claimMdService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->claimMdService = new ClaimMdService();
    }

    /** @test */
    public function it_successfully_sends_edi_file()
    {
        // Mock response data
        $mockResponseData = [
            'status' => 'success',
            'message' => 'File processed successfully'
        ];

        // Mock HTTP facade
        Http::fake([
            'svc.claim.md/services/upload/*' => Http::response($mockResponseData, 200)
        ]);

        // Test data
        $fileContent = 'ISA*00*...(sample EDI content)';
        $filename = 'test-edi-file.edi';

        // Make the request
        $result = $this->claimMdService->sendEdiFile($fileContent, $filename);

        // Assertions
        $this->assertTrue($result['success']);
        $this->assertEquals($mockResponseData, $result['data']);

        // Verify the request was made with correct parameters
        Http::assertSent(function ($request) use ($fileContent, $filename) {
            // Get the request body content
            $body = $request->body();

            // Check if the body contains the expected data
            return $request->hasHeader('Accept', 'application/xml') &&
                    str_contains($body, 'name="AccountKey"') &&
                    str_contains($body, config('services.claimmd.account_key')) &&
                    str_contains($body, 'name="File"') &&
                    str_contains($body, $fileContent) &&
                    str_contains($body, 'name="Filename"') &&
                    str_contains($body, $filename);
        });
    }

    /** @test */
    public function it_handles_failed_request()
    {
        // Mock failed response
        Http::fake([
            'svc.claim.md/services/upload/*' => Http::response('Error processing file', 400)
        ]);

        // Test data
        $fileContent = 'ISA*00*...(sample EDI content)';
        $filename = 'test-edi-file.edi';

        // Make the request
        $result = $this->claimMdService->sendEdiFile($fileContent, $filename);

        // Assertions
        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Failed to send EDI file', $result['error']);
    }

    /** @test */
    public function it_handles_exception_during_request()
    {
        // Mock HTTP facade to throw exception
        Http::fake([
            'svc.claim.md/services/upload/*' => function () {
                throw new \Exception('Network error');
            }
        ]);

        // Test data
        $fileContent = 'ISA*00*...(sample EDI content)';
        $filename = 'test-edi-file.edi';

        // Make the request
        $result = $this->claimMdService->sendEdiFile($fileContent, $filename);

        // Assertions
        $this->assertFalse($result['success']);
        $this->assertEquals('Network error', $result['error']);
    }
}
