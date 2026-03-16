<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZTF Foundation - PDF</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #333;
            padding: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #2c3e50;
        }

        header h1 {
            color: #2c3e50;
            font-size: 20pt;
            margin-bottom: 5px;
        }

        header h2 {
            color: #7f8c8d;
            font-size: 14pt;
            font-weight: normal;
        }

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section h2 {
            background-color: #34495e;
            color: white;
            padding: 8px 12px;
            font-size: 13pt;
            margin-bottom: 15px;
        }

        .info-grid {
            display: block;
        }

        .info-grid p {
            margin-bottom: 8px;
            padding: 5px 0;
            border-bottom: 1px solid #ecf0f1;
        }

        .info-grid p strong {
            color: #2c3e50;
            display: inline-block;
            width: 45%;
            font-weight: bold;
        }

        .info-grid p.full-width {
            display: block;
        }

        .info-grid p.full-width strong {
            display: block;
            width: 100%;
            margin-bottom: 5px;
        }

        .page-break {
            page-break-before: always;
        }

        .yes-no {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-weight: bold;
        }

        .documents-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .documents-table th {
            background-color: #ecf0f1;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #bdc3c7;
        }

        .documents-table td {
            padding: 8px;
            border: 1px solid #bdc3c7;
        }

        .documents-table td.uploaded {
            color: #27ae60;
            font-weight: bold;
        }

        .documents-table td.not-uploaded {
            color: #e74c3c;
        }

        footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 2px solid #2c3e50;
            text-align: center;
            font-size: 9pt;
            color: #7f8c8d;
        }
    </style>
</head>
<body>

<header>
    <h1>Zacharias Tannee Fomum Foundation</h1>
    <h2>Headquarters Staff Registration</h2>
    <p style="margin-top: 10px; font-size: 9pt;">Generated on {{ date('F d, Y') }}</p>
</header>

<!-- Section 1 : Personal Information -->
<div class="section">
    <h2>1. Personal Information (Identity)</h2>
    <div class="info-grid">
        <p><strong>Full Name:</strong> {{ $ouvrier->fullName ?? 'N/A' }}</p>
        <p><strong>Father's Name:</strong> {{ $ouvrier->fathersName ?? 'N/A' }}</p>
        <p><strong>Mother's Name:</strong> {{ $ouvrier->mothersName ?? 'N/A' }}</p>
        <p><strong>Date Of Birth:</strong> {{ isset($ouvrier->dateOfBirth) ? \Carbon\Carbon::parse($ouvrier->dateOfBirth)->format('d/m/Y') : 'N/A' }}</p>
        <p><strong>Place Of Birth:</strong> {{ $ouvrier->placeOfBirth ?? 'N/A' }}</p>
        <p><strong>Passport / ID Number:</strong> {{ $ouvrier->idPassportNumber ?? 'N/A' }}</p>
    </div>
</div>

<!-- Section 2 : Contact & Location -->
<div class="section">
    <h2>2. Contact Details & Location</h2>
    <div class="info-grid">
        <p class="full-width"><strong>Full Address:</strong> {{ $ouvrier->fullAddress ?? 'N/A' }}</p>
        <p><strong>Phone Number:</strong> {{ $ouvrier->phoneNumber ?? 'N/A' }}</p>
        <p><strong>Whatsapp Number:</strong> {{ $ouvrier->whatsappNumber ?? 'N/A' }}</p>
        <p><strong>Region:</strong> {{ $ouvrier->region ?? 'N/A' }}</p>
        <p><strong>Place of Residence:</strong> {{ $ouvrier->placeOfResidence ?? 'N/A' }}</p>
        <p><strong>Department of Origin:</strong> {{ $ouvrier->departmentOfOrigin ?? 'N/A' }}</p>
        <p><strong>Village Name:</strong> {{ $ouvrier->village ?? 'N/A' }}</p>
        <p><strong>Ethnicity:</strong> {{ $ouvrier->ethnicity ?? 'N/A' }}</p>
        <p><strong>Number Of Siblings:</strong> {{ $ouvrier->numberOfSiblings ?? 'N/A' }}</p>
        <p><strong>Next Of Kin Name:</strong> {{ $ouvrier->nextOfKinName ?? 'N/A' }}</p>
        <p><strong>Next Of Kin City:</strong> {{ $ouvrier->nextOfKinCity ?? 'N/A' }}</p>
        <p><strong>Next Of Kin Contact:</strong> {{ $ouvrier->nextOfKinContact ?? 'N/A' }}</p>
        <p><strong>Family Head Name:</strong> {{ $ouvrier->familyHeadName ?? 'N/A' }}</p>
        <p><strong>Family Head City:</strong> {{ $ouvrier->familyHeadCity ?? 'N/A' }}</p>
        <p><strong>Family Head Contact:</strong> {{ $ouvrier->familyHeadContact ?? 'N/A' }}</p>
    </div>
</div>

<!-- Section 3 : Spiritual Life -->
<div class="section page-break">
    <h2>3. Spiritual Life</h2>
    <div class="info-grid">
        <p><strong>Conversion Date:</strong> {{ isset($ouvrier->conversionDate) ? \Carbon\Carbon::parse($ouvrier->conversionDate)->format('d/m/Y') : 'N/A' }}</p>
        <p><strong>Baptism By Immersion:</strong> {{ $ouvrier->baptismByImmersion ?? 'N/A' }}</p>
        <p><strong>Baptism In Holy Spirit:</strong> {{ $ouvrier->baptismInHolySpirit ?? 'N/A' }}</p>
        <p class="full-width"><strong>Home Church:</strong> {{ $ouvrier->homeChurch ?? 'N/A' }}</p>
        <p><strong>Center:</strong> {{ $ouvrier->center ?? 'N/A' }}</p>
        <p><strong>Disciple Maker Name:</strong> {{ $ouvrier->discipleMakerName ?? 'N/A' }}</p>
        <p><strong>Disciple Maker Contact:</strong> {{ $ouvrier->discipleMakerContact ?? 'N/A' }}</p>
        <p><strong>Spiritual Parentage Name:</strong> {{ $ouvrier->spiritualParentageName ?? 'N/A' }}</p>
        <p><strong>Spiritual Parentage Contact:</strong> {{ $ouvrier->spiritualParentageContact ?? 'N/A' }}</p>
        <p class="full-width"><strong>Relationship with Spiritual Parent:</strong> {{ $ouvrier->spiritualParentageRelationship ?? 'N/A' }}</p>
        <p class="full-width"><strong>Testimony:</strong> {{ $ouvrier->testimony ?? 'N/A' }}</p>
    </div>
</div>

<!-- Section 4 : Family Life -->
<div class="section">
    <h2>4. Family Life</h2>
    <div class="info-grid">
        <p><strong>Marital Status:</strong> {{ $ouvrier->maritalStatus ?? 'N/A' }}</p>
        <p><strong>Spouse Name:</strong> {{ $ouvrier->spouseName ?? 'N/A' }}</p>
        <p><strong>Spouse Contact:</strong> {{ $ouvrier->spouseContact ?? 'N/A' }}</p>
        <p><strong>Number Of Legitimate Children:</strong> {{ $ouvrier->numberOfLegitimateChildren ?? 'N/A' }}</p>
        <p class="full-width"><strong>Legitimate Children Details:</strong> {{ $ouvrier->legitimateChildrenDetails ?? 'N/A' }}</p>
        <p><strong>Number Of Dependents:</strong> {{ $ouvrier->numberOfDependents ?? 'N/A' }}</p>
        <p class="full-width"><strong>Dependents Details:</strong> {{ $ouvrier->dependentsDetails ?? 'N/A' }}</p>
        <p class="full-width"><strong>Siblings Details:</strong> {{ $ouvrier->siblingsDetails ?? 'N/A' }}</p>
    </div>
</div>

<!-- Section 5 : Professional Life -->
<div class="section page-break">
    <h2>5. Professional Life</h2>
    <div class="info-grid">
        <p><strong>Education Financer:</strong> {{ $ouvrier->educationFinancer ?? 'N/A' }}</p>
        <p><strong>Education Level:</strong> {{ $ouvrier->educationLevel ?? 'N/A' }}</p>
        <p><strong>Degree Obtained:</strong> {{ $ouvrier->degreeObtained ?? 'N/A' }}</p>
        <p class="full-width"><strong>Activity Before HQ:</strong> {{ $ouvrier->activityBeforeHQ ?? 'N/A' }}</p>
        <p><strong>HQ Entry Date:</strong> {{ isset($ouvrier->hqEntryDate) ? \Carbon\Carbon::parse($ouvrier->hqEntryDate)->format('d/m/Y') : 'N/A' }}</p>
        <p><strong>HQ Department:</strong> {{ $ouvrier->hqDepartment ?? 'N/A' }}</p>
        <p class="full-width"><strong>Origin Country City:</strong> {{ $ouvrier->originCountryCity ?? 'N/A' }}</p>
        <p class="full-width"><strong>Department Responsibility:</strong> {{ $ouvrier->departmentResponsibility ?? 'N/A' }}</p> 
    </div>
</div>

<!-- Section 6 : Commissioning -->
<div class="section">
    <h2>6. Commissioning</h2>
    <div class="info-grid">
        <p class="full-width"><strong>Introduced to HQ by:</strong> {{ $ouvrier->whoIntroducedToHQ ?? 'N/A' }}</p>
        <p><strong>Have you received the Call Of God:</strong> {{ $ouvrier->callOfGod ?? 'N/A' }}</p>
        <p class="full-width"><strong>Call Details:</strong> {{ $ouvrier->whatCallConsistsOf ?? 'N/A' }}</p>
        <p><strong>Is Your family Aware?:</strong> {{ $ouvrier->familyAwareOfCall ?? 'N/A' }}</p>
        <p class="full-width"><strong>Emergency Contact:</strong> {{ $ouvrier->emergencyContactDeath ?? 'N/A' }}</p>
        <p class="full-width"><strong>Burial Location:</strong> {{ $ouvrier->burialLocation ?? 'N/A' }}</p>
    </div>
</div>

<!-- Section 7 : Possessions & Health -->
<div class="section page-break">
    <h2>7. Possessions & Health History</h2>
    <div class="info-grid">
        <p class="full-width"><strong>Possessions:</strong> {{ $ouvrier->yourPossessions ?? 'N/A' }}</p>
        <p class="full-width"><strong>Sources Of Income:</strong> {{ $ouvrier->sourcesOfIncome ?? 'N/A' }}</p>
        <p class="full-width"><strong>Health Problems:</strong> {{ $ouvrier->healthProblems ?? 'N/A' }}</p>
        <p><strong>Undergoing Treatment?:</strong> {{ $ouvrier->underTreatment ?? 'N/A' }}</p>
        <p class="full-width"><strong>Surgery Details:</strong> {{ $ouvrier->operationsDetails ?? 'N/A' }}</p>
    </div>
</div>

<!-- Section 8 : Judicial History -->
<div class="section">
    <h2>8. Judicial History</h2>
    <div class="info-grid">
        <p><strong>Problems with anyone?:</strong> {{ $ouvrier->problemsWithAnyone ?? 'N/A' }}</p>
        <p class="full-width"><strong>Reason For Problems:</strong> {{ $ouvrier->reasonForProblems ?? 'N/A' }}</p>
        <p><strong>Been To Prison?:</strong> {{ $ouvrier->beenToPrison ?? 'N/A' }}</p>
        <p class="full-width"><strong>Reason For Prison:</strong> {{ $ouvrier->reasonForPrison ?? 'N/A' }}</p>
    </div>
</div>

<footer>
    <p><strong>Zacharias Tannee Fomum Foundation</strong></p>
    <p>This document is confidential and contains sensitive personal information.</p>
    <p>© {{ date('Y') }} ZTF Foundation - Headquarters Staff Management System</p>
</footer>

</body>
</html>
