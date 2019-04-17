<?php namespace AliasProject\GoogleSheets;

use Google_Client, Google_Service_Sheets, Google_Service_Sheets_ValueRange;

class GoogleSheets
{
    private $client = null;
    private $service = null;

    /**
     * Create new instance
     *
     * @param string $config - API Config
     * @param string $applicationName - Application Name
     */
    public function __construct($config = false, string $applicationName = 'Google Sheets')
    {
        $this->client = new Google_Client();

        // Set Authentication
        if (empty($config)) {
            $config = [
                'application_name' => $applicationName,
                'use_application_default_credentials' => true,
                'access_type' => 'offline',
                'include_granted_scopes' => [Google_Service_Sheets::SPREADSHEETS]
            ]
        }

        $this->client->setAuthConfig($config);

        $this->service = new Google_Service_Sheets($this->client);
    }

    /**
     * Add or update subscriber
     *
     * @param string $email - Subscriber Email
     * @param string $drip_id - Current user Drip ID for update
     * @param array $custom_fields - Array of custom fields to save to user
     */
    public function save(string $spreadsheetId)
    {
        $requestBody = new Google_Service_Sheets_ValueRange([
            'range' => $updateRange,
            'majorDimension' => 'ROWS',
            'values' => ['values' => date('c')],
        ]);

        $response = $this->service->spreadsheets_values->update(
            $spreadsheetId,
            $tableRange,
            $updateBody,
            ['valueInputOption' => 'USER_ENTERED']
        );

        return $response
    }

    public function read(string $spreadsheet_id, string $range)
    {
        $response = $this->service->spreadsheets_values->get($spreadsheet_id, $range);
        $values = $response->getValues();

        return $values;
        return $this->makeRequest($url, $data, true);
    }
}
