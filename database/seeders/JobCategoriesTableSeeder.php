<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('job_categories')->insert([
            0 => array('id' => 1, 'category_name' => 'Accounting/Finance', 'category_slug' => 'accountingfinance', 'job_count' => 0),
            1 => array('id' => 2, 'category_name' => 'Bank/ Non-Bank Fin. Institution', 'category_slug' => 'bank-non-bank-fin-institution', 'job_count' => 0),
            2 => array('id' => 3, 'category_name' => 'Commercial/Supply Chain', 'category_slug' => 'commercialsupply-chain', 'job_count' => 0),
            3 => array('id' => 4, 'category_name' => 'Education/Training', 'category_slug' => 'educationtraining', 'job_count' => 0),
            4 => array('id' => 5, 'category_name' => 'Engineer/Architects', 'category_slug' => 'engineerarchitects', 'job_count' => 0),
            5 => array('id' => 6, 'category_name' => 'Garments/Textile', 'category_slug' => 'garmentstextile', 'job_count' => 0),
            6 => array('id' => 7, 'category_name' => 'HR/Org. Development', 'category_slug' => 'hrorg-development', 'job_count' => 0),
            7 => array('id' => 8, 'category_name' => 'Gen Mgt/Admin', 'category_slug' => 'gen-mgtadmin', 'job_count' => 0),
            8 => array('id' => 9, 'category_name' => 'Design/Creative', 'category_slug' => 'designcreative', 'job_count' => 0),
            9 => array('id' => 10, 'category_name' => 'Production/Operation', 'category_slug' => 'productionoperation', 'job_count' => 0),
            10 => array('id' => 11, 'category_name' => 'Hospitality/ Travel/ Tourism', 'category_slug' => 'hospitality-travel-tourism', 'job_count' => 0),
            11 => array('id' => 12, 'category_name' => 'Beauty Care/ Health & Fitness', 'category_slug' => 'beauty-care-health-fitness', 'job_count' => 0),
            12 => array('id' => 13, 'category_name' => 'Electrician/ Construction/ Repair', 'category_slug' => 'electrician-construction-repair', 'job_count' => 0),
            13 => array('id' => 14, 'category_name' => 'IT & Telecommunication', 'category_slug' => 'it-telecommunication', 'job_count' => 0),
            14 => array('id' => 15, 'category_name' => 'Marketing/Sales', 'category_slug' => 'marketingsales', 'job_count' => 0),
            15 => array('id' => 16, 'category_name' => 'Customer Support/Call Centre', 'category_slug' => 'customer-supportcall-centre', 'job_count' => 0),
            16 => array('id' => 17, 'category_name' => 'Media/Ad./Event Mgt.', 'category_slug' => 'mediaadevent-mgt', 'job_count' => 0),
            17 => array('id' => 18, 'category_name' => 'Medical/Pharma', 'category_slug' => 'medicalpharma', 'job_count' => 0),
            18 => array('id' => 19, 'category_name' => 'Agro (Plant/Animal/Fisheries)', 'category_slug' => 'agro-plantanimalfisheries', 'job_count' => 0),
            19 => array('id' => 20, 'category_name' => 'NGO/Development', 'category_slug' => 'ngodevelopment', 'job_count' => 0),
            20 => array('id' => 21, 'category_name' => 'Research/Consultancy', 'category_slug' => 'researchconsultancy', 'job_count' => 0),
            21 => array('id' => 22, 'category_name' => 'Secretary/Receptionist', 'category_slug' => 'secretaryreceptionist', 'job_count' => 0),
            22 => array('id' => 23, 'category_name' => 'Data Entry/Operator/BPO', 'category_slug' => 'data-entryoperatorbpo', 'job_count' => 0),
            23 => array('id' => 24, 'category_name' => 'Driving/Motor Technician', 'category_slug' => 'drivingmotor-technician', 'job_count' => 0),
            24 => array('id' => 25, 'category_name' => 'Security/Support Service', 'category_slug' => 'securitysupport-service', 'job_count' => 0),
            25 => array('id' => 26, 'category_name' => 'Law/Legal', 'category_slug' => 'lawlegal', 'job_count' => 0),
            26 => array('id' => 27, 'category_name' => 'Others', 'category_slug' => 'others', 'job_count' => 0),
        ]);
    }
}
