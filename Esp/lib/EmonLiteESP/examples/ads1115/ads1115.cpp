/*

EmonLiteESP ADS1115 Example

Energy Monitor Library for ESP8266 based on EmonLib
Currently only support current sensing

NOTE: Requires Adafruit_ADS1015 library

Copyright (C) 2016 by Xose Pérez <xose dot perez at gmail dot com>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

#include <Arduino.h>
#include "EmonLiteESP.h"
#include <Wire.h>
#include "ADS1115.h"

// -----------------------------------------------------------------------------
// Configuration
// -----------------------------------------------------------------------------

// Addess of the ADS1115 in the I2C module
#define ADS1115_ADDRESS         0x4A

// Port to sample from
#define ADS1115_PORT            ADS1115_MUX_P3_NG // port 3

// The ADC input range (or gain) can be changed via the following
// functions, but be careful never to exceed VDD +0.3V max, or to
// exceed the upper and lower limits if you adjust the input range!
// Setting these values incorrectly may destroy your ADC!
//                                                                ADS1015  ADS1115
//                                                                -------  -------
// ads.setGain(GAIN_TWOTHIRDS);  // 2/3x gain +/- 6.144V  1 bit = 3mV      0.1875mV (default)
// ads.setGain(GAIN_ONE);        // 1x gain   +/- 4.096V  1 bit = 2mV      0.125mV
// ads.setGain(GAIN_TWO);        // 2x gain   +/- 2.048V  1 bit = 1mV      0.0625mV
// ads.setGain(GAIN_FOUR);       // 4x gain   +/- 1.024V  1 bit = 0.5mV    0.03125mV
// ads.setGain(GAIN_EIGHT);      // 8x gain   +/- 0.512V  1 bit = 0.25mV   0.015625mV
// ads.setGain(GAIN_SIXTEEN);    // 16x gain  +/- 0.256V  1 bit = 0.125mV  0.0078125mV
#define ADS1115_GAIN            ADS1115_PGA_4P096 // GAIN_ONE

// If you are using a nude ESP8266 board it will be 1.0V
// If using a NodeMCU there is a voltage divider in place, so use 3.3V instead.
// If using an ADS1115 depends on gain factor, check table and duplicate (only +)
#define REFERENCE_VOLTAGE       8.192

// Precision of the ADC measure in bits. Arduinos and ESP8266 use 10bits ADCs.
// The ADS1115 is a 16bits ADC
#define ADC_BITS                16

// This is basically the volts per amper ratio of your current measurement sensor.
// If your sensor has a voltage output it will be written in the sensor enclosure,
// something like "30V 1A", otherwise it will depend on the burden resistor you are
// using.
#define CURRENT_RATIO           30

// This version of the library only calculate aparent power, so it asumes a fixes
// mains voltage
#define MAINS_VOLTAGE           230

// Sample for 1 second
#define SAMPLING_MODE           EMON_MODE_MSECONDS
#define SAMPLING_VALUE          1000

// Do 1000 samplings
//#define SAMPLING_MODE           EMON_MODE_SAMPLES
//#define SAMPLING_VALUE          1000

// Time between readings, this is not specific of the library but on this sketch
#define MEASUREMENT_INTERVAL    10000

// -----------------------------------------------------------------------------
// Globals
// -----------------------------------------------------------------------------

ADS1115 ads(ADS1115_ADDRESS);
EmonLiteESP emon;

// -----------------------------------------------------------------------------
// Energy Monitor
// -----------------------------------------------------------------------------

void powerMonitorSetup() {

    // I2CDevLib
    Wire.begin();
    ads.initialize();
    ads.setMode(ADS1115_MODE_SINGLESHOT);
    ads.setRate(ADS1115_RATE_860);
    ads.setGain(ADS1115_GAIN);
    ads.setConversionReadyPinMode();

    // Configure EmonLiteESP
    emon.initCurrent([]() -> unsigned int {
        ads.setMultiplexer(ADS1115_PORT);
        return ads.getConversion(true);
    }, ADC_BITS, REFERENCE_VOLTAGE, CURRENT_RATIO);

    // Warmup
    emon.getCurrent(SAMPLING_VALUE, SAMPLING_MODE);

}

void powerMonitorLoop() {

    static unsigned long last_check = 0;
    if ((millis() - last_check) > MEASUREMENT_INTERVAL) {
        last_check = millis();

        double current = emon.getCurrent(SAMPLING_VALUE, SAMPLING_MODE);
        Serial.printf("[ENERGY] Power now: %dW\n", int(current * MAINS_VOLTAGE));

    }
}


// -----------------------------------------------------------------------------
// Main methods
// -----------------------------------------------------------------------------

void setup() {
    Serial.begin(115200);
    powerMonitorSetup();
}

void loop() {
    powerMonitorLoop();
    delay(1);
}
