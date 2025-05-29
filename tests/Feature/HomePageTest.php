<?php
it('Home Page Load', function () {

    $response = $this->get('/');

    $response->assertStatus(200);
});
