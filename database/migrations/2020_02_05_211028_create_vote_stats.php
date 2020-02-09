<?php

use Illuminate\Database\Migrations\Migration;

class CreateVoteStats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement("
            CREATE VIEW v_aggr_vote AS
            SELECT     a.user_id, 
                       YEAR(a.run_date) AS `yr_bucket` ,
                       b.v_timing_method_a, 
                       b.v_timing_method_b, 
                       b.v_timing_method_c, 
                       b.v_timing_method_d, 
                       b.v_hide_timings, 
                       Floor((Greatest(personal_best, 4500) - 4500) / 600) AS `pb_bucket` 
            FROM       ( 
                                SELECT   user_id, 
                                         run_date,  
                                         personal_best, 
                                         Rank() OVER (PARTITION BY user_id ORDER BY personal_best ASC) AS `rank`
                                FROM     t_run WHERE category_id = (SELECT id from t_category where category_name = 'Any%')) a 
            RIGHT JOIN t_vote b 
            ON         a.user_id = b.user_id 
            WHERE      a.`rank` = 1;  
       ");


        \Illuminate\Support\Facades\DB::statement("
            CREATE VIEW v_aggr_vote_yr AS
            SELECT   `yr_bucket`                        AS `year`, 
                     Sum(v_timing_method_a = 'Yes')     AS `timing_method_a.options.yes`, 
                     Sum(v_timing_method_a = 'No')      AS `timing_method_a.options.no`, 
                     Sum(v_timing_method_a = 'No Vote') AS `timing_method_a.options.no_vote`, 
                     Sum(v_timing_method_b = 'Yes')     AS `timing_method_b.options.yes`, 
                     Sum(v_timing_method_b = 'No')      AS `timing_method_b.options.no`, 
                     Sum(v_timing_method_b = 'No Vote') AS `timing_method_b.options.no_vote`, 
                     Sum(v_timing_method_c = 'Yes')     AS `timing_method_c.options.yes`, 
                     Sum(v_timing_method_c = 'No')      AS `timing_method_c.options.no`, 
                     Sum(v_timing_method_c = 'No Vote') AS `timing_method_c.options.no_vote`, 
                     Sum(v_timing_method_d = 'Yes')     AS `timing_method_d.options.yes`, 
                     Sum(v_timing_method_d = 'No')      AS `timing_method_d.options.no`, 
                     Sum(v_timing_method_d = 'No Vote') AS `timing_method_d.options.no_vote`, 
                     Sum(v_hide_timings = 'Yes')        AS `hide_timings.options.yes`, 
                     Sum(v_hide_timings = 'No')         AS `hide_timings.options.no`, 
                     Sum(v_hide_timings = 'No Vote')    AS `hide_timings.options.no_vote` 
            FROM v_aggr_vote
            GROUP BY `yr_bucket`;
       ");

        \Illuminate\Support\Facades\DB::statement("
            CREATE VIEW v_aggr_vote_pb AS
            SELECT   Sec_to_time(`pb_bucket` * 600 + 5100) AS `pb`, 
                     Sum(v_timing_method_a = 'Yes')        AS `timing_method_a.options.yes`, 
                     Sum(v_timing_method_a = 'No')         AS `timing_method_a.options.no`, 
                     Sum(v_timing_method_a = 'No Vote')    AS `timing_method_a.options.no_vote`, 
                     Sum(v_timing_method_b = 'Yes')        AS `timing_method_b.options.yes`, 
                     Sum(v_timing_method_b = 'No')         AS `timing_method_b.options.no`, 
                     Sum(v_timing_method_b = 'No Vote')    AS `timing_method_b.options.no_vote`, 
                     Sum(v_timing_method_c = 'Yes')        AS `timing_method_c.options.yes`, 
                     Sum(v_timing_method_c = 'No')         AS `timing_method_c.options.no`, 
                     Sum(v_timing_method_c = 'No Vote')    AS `timing_method_c.options.no_vote`, 
                     Sum(v_timing_method_d = 'Yes')        AS `timing_method_d.options.yes`, 
                     Sum(v_timing_method_d = 'No')         AS `timing_method_d.options.no`, 
                     Sum(v_timing_method_d = 'No Vote')    AS `timing_method_d.options.no_vote`, 
                     Sum(v_hide_timings = 'Yes')           AS `hide_timings.options.yes`, 
                     Sum(v_hide_timings = 'No')            AS `hide_timings.options.no`, 
                     Sum(v_hide_timings = 'No Vote')       AS `hide_timings.options.no_vote` 
            FROM v_aggr_vote
            GROUP BY `pb_bucket`;         
        ");

        \Illuminate\Support\Facades\DB::statement("
        CREATE VIEW v_aggr_vote_pb_cont AS
            SELECT 
                a.val AS pb_bucket,
                SUM(CASE
                    WHEN v_timing_method_a = 'Yes' THEN 1
                    ELSE 0
                END) AS `timing_method_a.options.yes`,
                SUM(CASE
                    WHEN v_timing_method_a = 'No' THEN 1
                    ELSE 0
                END) AS `timing_method_a.options.no`,
                SUM(CASE
                    WHEN v_timing_method_a = 'No Vote' THEN 1
                    ELSE 0
                END) AS `timing_method_a.options.no_vote`,
                SUM(CASE
                    WHEN v_timing_method_b = 'Yes' THEN 1
                    ELSE 0
                END) AS `timing_method_b.options.yes`,
                SUM(CASE
                    WHEN v_timing_method_b = 'No' THEN 1
                    ELSE 0
                END) AS `timing_method_b.options.no`,
                SUM(CASE
                    WHEN v_timing_method_b = 'No Vote' THEN 1
                    ELSE 0
                END) AS `timing_method_b.options.no_vote`,
                SUM(CASE
                    WHEN v_timing_method_c = 'Yes' THEN 1
                    ELSE 0
                END) AS `timing_method_c.options.yes`,
                SUM(CASE
                    WHEN v_timing_method_c = 'No' THEN 1
                    ELSE 0
                END) AS `timing_method_c.options.no`,
                SUM(CASE
                    WHEN v_timing_method_c = 'No Vote' THEN 1
                    ELSE 0
                END) AS `timing_method_c.options.no_vote`,
                SUM(CASE
                    WHEN v_timing_method_d = 'Yes' THEN 1
                    ELSE 0
                END) AS `timing_method_d.options.yes`,
                SUM(CASE
                    WHEN v_timing_method_d = 'No' THEN 1
                    ELSE 0
                END) AS `timing_method_d.options.no`,
                SUM(CASE
                    WHEN v_timing_method_d = 'No Vote' THEN 1
                    ELSE 0
                END) AS `timing_method_d.options.no_vote`,
                SUM(CASE
                    WHEN v_hide_timings = 'Yes' THEN 1
                    ELSE 0
                END) AS `hide_timings.options.yes`,
                SUM(CASE
                    WHEN v_hide_timings = 'No' THEN 1
                    ELSE 0
                END) AS `hide_timings.options.no`,
                SUM(CASE
                    WHEN v_hide_timings = 'No Vote' THEN 1
                    ELSE 0
                END) AS `hide_timings.options.no_vote`,
                (SELECT 
                        COUNT(*)
                    FROM
                        t_vote) - COUNT(*) AS `not_applicable`,
                SEC_TO_TIME(a.val * 600 + 5100) AS `pb`
            FROM
                (SELECT 0 AS val UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 9999) a
                    LEFT JOIN
                v_aggr_vote b ON a.val >= b.pb_bucket
            GROUP BY 1;         
		
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::statement('DROP VIEW IF EXISTS v_aggr_vote;');
        \Illuminate\Support\Facades\DB::statement('DROP VIEW IF EXISTS v_aggr_vote_yr;');
        \Illuminate\Support\Facades\DB::statement('DROP VIEW IF EXISTS v_aggr_vote_pb;');
        \Illuminate\Support\Facades\DB::statement('DROP VIEW IF EXISTS v_aggr_vote_pb_cont;');
    }
}
