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
            $this->client->useApplicationDefaultCredentials();
        } else {
            $this->client->setAuthConfig($config);
        }

        $this->client->addScope(Google_Service_Sheets::SPREADSHEETS);
        $this->client->setApplicationName($applicationName);
        $this->client->setAccessType('offline');

        $this->service = new Google_Service_Sheets($this->client);
    }

    /**
     * Add or update subscriber
     *
     * @param string $email - Subscriber Email
     * @param string $drip_id - Current user Drip ID for update
     * @param array $custom_fields - Array of custom fields to save to user
     */
    public function update(string $spreadsheetId, string $range, array $data)
    {
        $requestBody = new Google_Service_Sheets_ValueRange([
            'range' => $range,
            'majorDimension' => 'ROWS',
            'values' => ['values' => $data],
        ]);

        $response = $this->service->spreadsheets_values->append(
            $spreadsheetId,
            $range,
            $requestBody,
            ['valueInputOption' => 'USER_ENTERED']
        );

        return $response;
    }

    public function read(string $spreadsheet_id, string $range)
    {
        $response = $this->service->spreadsheets_values->get($spreadsheet_id, $range);
        $values = $response->getValues();

        return $values;
    }
}
