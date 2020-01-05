<?php

use Illuminate\Database\Migrations\Migration;

class CreateResultsView extends Migration
{
  public function up()
  {
    \DB::statement("
            CREATE VIEW v_raw 
            AS
            SELECT t_vote.id                        AS 'vote_id', 
                   t_vote.src_id                    AS 'user_id', 
                   t_vote.src_name                  AS 'user_name', 
                   t_vote.has_voted                 AS 'has_voted', 
                   t_vote.has_src_run               AS 'has_src_run', 
                   t_vote.is_verified               AS 'is_verified', 
                   t_vote.custom_run_url            AS 'custom_run_url', 
                   t_vote.v_hide_timings            AS 'v_hide_timings', 
                   t_vote.v_option_a                AS 'v_option_a', 
                   t_vote.v_option_b                AS 'v_option_b', 
                   t_vote.v_option_c                AS 'v_option_c', 
                   t_vote.v_option_d                AS 'v_option_d', 
                   t_vote.v_option_e                AS 'v_option_e', 
                   t_vote.comment                   AS 'comment', 
                   t_category.src_id                AS 'category_id', 
                   t_category.src_name              AS 'category_name', 
                   t_category.src_game_id           AS 'game_id', 
                   t_category.src_game_name         AS 'game_name', 
                   t_run.src_id                     AS 'run_id', 
                   sec_to_time(t_run.personal_best) AS 'run_time', 
                   t_run.run_date                   AS 'run_date' 
            FROM   t_vote 
            LEFT JOIN (SELECT fk_t_category, 
                            fk_t_vote, 
                            Min(personal_best) AS personal_best 
                     FROM   t_run 
                     GROUP  BY fk_t_category, 
                               fk_t_vote) a 
                 ON a.fk_t_vote = t_vote.id 
            LEFT JOIN t_run 
                 ON t_run.fk_t_category = a.fk_t_category 
                    AND t_run.fk_t_vote = a.fk_t_vote 
                    AND t_run.personal_best = a.personal_best 
            LEFT JOIN t_category
                 ON t_run.fk_t_category = t_category.id;
        ");
  }

  public function down()
  {
    \DB::statement("DROP VIEW v_raw");
  }
}
