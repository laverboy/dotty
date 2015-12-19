# Dotty - Simple dot notation accessor class

_"Dotty is a very nice girl, but she doesn't have a lot to say."_

A simple class to get a value, or values, from an array, or many arrays, using dot notation.

[![Build Status](https://travis-ci.org/laverboy/dotty.svg?branch=master)](https://travis-ci.org/laverboy/dotty)

## Usage

    $array_to_search = [
        'name' => [
            'firstname' => 'Dotty',
            'lastname' => 'BoBotty',
        ],
        'address' => [
            'addressline1' => '12 Github strasse',
            'country' => 'internet' 
        ]
    ];
    
Get single value:    
    
    $firstname = Dotty::getValue('name.firstname', $array_to_search);
    // $firstname = 'Dotty'
    
Get array of values:

    $array_of_values = [
        'First name' => 'name.firstname',
        'Country' => 'address.country'
    ];
    
    $details = Dotty::getValues($array_of_values, $array_to_search);
    // $details = [
    //     'First name' => 'Dotty',
    //     'Country' => 'internet'
    // ]
    
Get array of values from multiple arrays to search:

    $manyDetails = Dotty::getValuesMultiple($array_of_values, [$array_to_search, $array_to_search]);
    // $manyDetails = [
    //     [
    //         'First name' => 'Dotty',
    //         'Country' => 'internet'
    //     ],
    //     [
    //         'First name' => 'Dotty',
    //         'Country' => 'internet'
    //     ]
    // ]