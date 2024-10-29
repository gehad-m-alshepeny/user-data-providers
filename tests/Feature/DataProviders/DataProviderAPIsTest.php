<?php

it('gets data from all data providers', function () {
  
    $response = $this->getJson('/api/v1/users');
    $response->assertStatus(200);
    $response->assertJson([
        'status' => 'success',
        'data' => [
            [
                'parentAmount' => 100,
                'currency' => 'EGP',
                'parentEmail' => 'parent1@parent.eu',
                'status' => 'authorised',
                'registerationDate' => '2018-11-30',
                'parentIdentification' => 'd3d29d70-1d25-11e3-8591-034165a3a613',
            ]
        ]
    ]);
 });
 

 it('gets data from DataProviderX', function () {
  
    $response = $this->getJson('/api/v1/users?provider=DataProviderX');
    $response->assertStatus(200);
    
    $response->assertJson([
        'status' => 'success',
        'data' => [
            [
                'parentAmount' => 100,
                'currency' => 'EGP',
                'parentEmail' => 'parent1@parent.eu',
                'status' => 'authorised',
                'registerationDate' => '2018-11-30',
                'parentIdentification' => 'd3d29d70-1d25-11e3-8591-034165a3a613',
            ]
        ]
    ]);
});

it('gets data from DataProviderY', function () {
  
    $response = $this->getJson('/api/v1/users?provider=DataProviderY');
    $response->assertStatus(200);
    $response->assertJson([
        'status' => 'success',
        'data' => [
            [
                'parentAmount' => 300,
                'currency' => 'AED',
                'email' => 'parenty1@parent.eu',
                'status' => 'authorised',
                'created_at' => '22/12/2018',
                'id' => '4fc2-a8d1',
            ]
        ]
    ]);
});

 it('test dataproviders with wrong status', function () {
    $response = $this->getJson('/api/v1/users?status=eee');
    $response->assertJson([]);
  
 });


 it('gets data from all data providers with combined filters', function () {
    $response = $this->getJson('/api/v1/users?provider=DataProviderX&status=authorised&currency=EGP&balanceMin=0&balanceMax=500');
    
    $response->assertStatus(200);

    $response->assertJson([
        'status' => 'success',
        'data' => [
            [
                'parentAmount' => 100,
                'currency' => 'EGP',
                'parentEmail' => 'parent1@parent.eu',
                'status' => 'authorised',
                'registerationDate' => '2018-11-30',
                'parentIdentification' => 'd3d29d70-1d25-11e3-8591-034165a3a613',
            ]
        ]
    ]);
});

