<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hq_staff_forms', function (Blueprint $table) {
            $table->id();

            // Section 1: Personal Information
            $table->string('fullName', 255);
            $table->string('fathersName', 255)->nullable()->default(null);
            $table->string('mothersName', 255)->nullable()->default(null);
            $table->date('dateOfBirth')->nullable()->default(null);
            $table->string('placeOfBirth', 255)->nullable()->default(null);
            $table->string('idPassportNumber', 255)->nullable()->default(null);

            // Section 2: Contact & Location
            $table->text('fullAddress')->nullable()->default(null);
            $table->string('phoneNumber', 50)->nullable()->default(null);
            $table->string('whatsappNumber', 50)->nullable()->default(null);
            $table->string('region', 100)->nullable()->default(null);
            $table->string('placeOfResidence', 255)->nullable()->default(null);
            $table->string('departmentOfOrigin', 255)->nullable()->default(null);
            $table->string('village', 255)->nullable()->default(null);
            $table->string('ethnicity', 255)->nullable()->default(null);
            $table->integer('numberOfSiblings')->nullable()->default(null);
            $table->string('nextOfKinName', 255)->nullable()->default(null);
            $table->string('nextOfKinCity', 255)->nullable()->default(null);
            $table->string('nextOfKinContact', 50)->nullable()->default(null);
            $table->string('familyHeadName', 255)->nullable()->default(null);
            $table->string('familyHeadCity', 255)->nullable()->default(null);
            $table->string('familyHeadContact', 50)->nullable()->default(null);

            // Section 3: Spiritual Life
            $table->date('conversionDate')->nullable()->default(null);
            $table->string('baptismByImmersion', 5)->nullable()->default(null);
            $table->string('baptismInHolySpirit', 5)->nullable()->default(null);
            $table->string('homeChurch', 255)->nullable()->default(null);
            $table->string('center', 255)->nullable()->default(null);
            $table->string('discipleMakerName', 255)->nullable()->default(null);
            $table->string('discipleMakerContact', 50)->nullable()->default(null);
            $table->string('spiritualParentageName', 255)->nullable()->default(null);
            $table->string('spiritualParentageContact', 50)->nullable()->default(null);
            $table->text('spiritualParentageRelationship')->nullable()->default(null);
            $table->text('testimony')->nullable()->default(null);

            // Section 4: Family Life
            $table->string('maritalStatus', 20)->nullable()->default(null);
            $table->string('spouseName', 255)->nullable()->default(null);
            $table->string('spouseContact', 50)->nullable()->default(null);
            $table->integer('numberOfLegitimateChildren')->nullable()->default(null);
            $table->text('legitimateChildrenDetails')->nullable()->default(null);
            $table->integer('numberOfDependents')->nullable()->default(null);
            $table->text('dependentsDetails')->nullable()->default(null);
            $table->text('siblingsDetails')->nullable()->default(null);

            // Section 5: Professional Life
            $table->string('educationFinancer', 255)->nullable()->default(null);
            $table->string('educationLevel', 255)->nullable()->default(null);
            $table->string('degreeObtained', 255)->nullable()->default(null);
            $table->text('activityBeforeHQ')->nullable()->default(null);
            $table->date('hqEntryDate')->nullable()->default(null);
            $table->string('hqDepartment', 255)->nullable()->default(null);
            $table->string('originCountryCity', 255)->nullable()->default(null);
            $table->text('departmentResponsibility')->nullable()->default(null);

            // Section 6: Commissioning
            $table->text('whoIntroducedToHQ')->nullable()->default(null);
            $table->string('callOfGod', 5)->nullable()->default(null);
            $table->text('whatCallConsistsOf')->nullable()->default(null);
            $table->string('familyAwareOfCall', 5)->nullable()->default(null);
            $table->string('emergencyContactDeath', 255)->nullable()->default(null);
            $table->string('burialLocation', 255)->nullable()->default(null);

            // Section 7: Possessions & Health
            $table->text('yourPossessions')->nullable()->default(null);
            $table->text('sourcesOfIncome')->nullable()->default(null);
            $table->text('healthProblems')->nullable()->default(null);
            $table->string('underTreatment', 5)->nullable()->default(null);
            $table->text('operationsDetails')->nullable()->default(null);

            // Section 8: Judicial History
            $table->string('problemsWithAnyone', 5)->nullable()->default(null);
            $table->text('reasonForProblems')->nullable()->default(null);
            $table->string('beenToPrison', 5)->nullable()->default(null);
            $table->text('reasonForPrison')->nullable()->default(null);

            // Section 9: Documents
            $table->string('bulletin3_path', 255)->nullable()->default(null);
            $table->string('medical_certificate_path', 255)->nullable()->default(null);
            $table->string('diplomas_path', 255)->nullable()->default(null);
            $table->string('birth_marriage_certificates_path', 255)->nullable()->default(null);
            $table->string('cni_path', 255)->nullable()->default(null);
            $table->string('family_commitment_path', 255)->nullable()->default(null);
            $table->string('family_burial_agreement_path', 255)->nullable()->default(null);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hq_staff_forms');
    }
};
