<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement('
        CREATE VIEW v_result AS
        SELECT 
            \'timing_method_a\' AS \'label\', a.*, b.*, c.*
        FROM
            (SELECT 
                COUNT(*) AS \'Yes\'
            FROM
                t_vote
            WHERE
                v_timing_method_a = \'Yes\') AS a,
            (SELECT 
                COUNT(*) AS \'No\'
            FROM
                t_vote
            WHERE
                v_timing_method_a = \'No\') AS b,
            (SELECT 
                COUNT(*) AS \'No Vote\'
            FROM
                t_vote
            WHERE
                v_timing_method_a = \'No Vote\') AS c 
        UNION ALL SELECT 
            \'timing_method_b\' AS \'label\', a.*, b.*, c.*
        FROM
            (SELECT 
                COUNT(*) AS \'Yes\'
            FROM
                t_vote
            WHERE
                v_timing_method_b = \'Yes\') AS a,
            (SELECT 
                COUNT(*) AS \'No\'
            FROM
                t_vote
            WHERE
                v_timing_method_b = \'No\') AS b,
            (SELECT 
                COUNT(*) AS \'No Vote\'
            FROM
                t_vote
            WHERE
                v_timing_method_b = \'No Vote\') AS c 
        UNION ALL SELECT 
            \'timing_method_c\' AS \'label\', a.*, b.*, c.*
        FROM
            (SELECT 
                COUNT(*) AS \'Yes\'
            FROM
                t_vote
            WHERE
                v_timing_method_c = \'Yes\') AS a,
            (SELECT 
                COUNT(*) AS \'No\'
            FROM
                t_vote
            WHERE
                v_timing_method_c = \'No\') AS b,
            (SELECT 
                COUNT(*) AS \'No Vote\'
            FROM
                t_vote
            WHERE
                v_timing_method_c = \'No Vote\') AS c 
        UNION ALL SELECT 
            \'timing_method_d\' AS \'label\', a.*, b.*, c.*
        FROM
            (SELECT 
                COUNT(*) AS \'Yes\'
            FROM
                t_vote
            WHERE
                v_timing_method_d = \'Yes\') AS a,
            (SELECT 
                COUNT(*) AS \'No\'
            FROM
                t_vote
            WHERE
                v_timing_method_d = \'No\') AS b,
            (SELECT 
                COUNT(*) AS \'No Vote\'
            FROM
                t_vote
            WHERE
                v_timing_method_d = \'No Vote\') AS c 
        UNION ALL SELECT 
            \'hide_timings\' AS \'label\', a.*, b.*, c.*
        FROM
            (SELECT 
                COUNT(*) AS \'Yes\'
            FROM
                t_vote
            WHERE
                v_hide_timings = \'Yes\') AS a,
            (SELECT 
                COUNT(*) AS \'No\'
            FROM
                t_vote
            WHERE
                v_hide_timings = \'No\') AS b,
            (SELECT 
                COUNT(*) AS \'No Vote\'
            FROM
                t_vote
            WHERE
                v_hide_timings = \'No Vote\') AS c;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::statement('
        DROP VIEW v_result;
        ');
    }
}
