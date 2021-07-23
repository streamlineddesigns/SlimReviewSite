<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models;

class UsedRepliesController extends Controller
{
    /*
     * Index View
     */
    public function index($request, $response)
    {
        $view = 'usedReplies\index.twig';
        $usedReplies = Models\UsedReplies::select('used_replies.id', 'used_replies.reply_id', 'used_replies.created_at', 'platforms.name as platform_name', 'games.name as game_name', 'review_categories.name as review_categories_name', 'replies.text as reply_text')
                                         ->leftJoin('platform_used_replies', 'platform_used_replies.used_reply_id', '=', 'used_replies.id')
                                         ->leftJoin('platforms', 'platforms.id', '=', 'platform_used_replies.platform_id')
                                         ->leftJoin('game_used_replies', 'game_used_replies.used_reply_id', '=', 'used_replies.id')
                                         ->leftJoin('games', 'games.id', '=', 'game_used_replies.game_id')
                                         ->leftJoin('review_category_used_replies', 'review_category_used_replies.used_reply_id', '=', 'used_replies.id')
                                         ->leftJoin('review_categories', 'review_categories.id', '=', 'review_category_used_replies.review_category_id')
                                         ->leftJoin('replies', 'replies.id', '=', 'used_replies.reply_id')->get();
        
        return $this->container->get('view')->render($response, $view, ['usedReplies' => $usedReplies]);
    }

    /*
     * Create View
     */
    public function create($request, $response)
    {
        $view = 'usedReplies\create.twig';
        $platforms = Models\Platforms::all();
        $games = Models\Games::all();
        $reviewCategories = Models\ReviewCategories::all();
        return $this->container->get('view')->render($response, $view, ['platforms' => $platforms, 'games' => $games, 'reviewCategories' => $reviewCategories]);
    }

    /*
     * Create Endpoint
     */
    public function store($request, $response)
    {
        $form_data = $request->getParsedBody();
        $platform_id = (int) $form_data['platform_id'];
        $game_id = (int) $form_data['game_id'];
        $review_category_id = (int) $form_data['review_category_id'];
        $reply_id = (int) $form_data['reply_id'];

        $used_replies = Models\UsedReplies::create([
            "reply_id" => $reply_id,
        ]);

        $used_reply_id = $used_replies->id;
        if ($used_reply_id != null) {

            $platform_used_replies = Models\PlatformUsedReplies::create([
                "platform_id" => $platform_id,
                "used_reply_id" => $used_reply_id,
            ]);

            $game_used_replies = Models\GameUsedReplies::create([
                "game_id" => $game_id,
                "used_reply_id" => $used_reply_id,
            ]);

            $review_category_used_replies = Models\ReviewCategoryUsedReplies::create([
                "review_category_id" => $review_category_id,
                "used_reply_id" => $used_reply_id,
            ]);

            $this->container->get('flash')->addMessage('success', 'Successfully generated reply message!');
        } else {
            $this->container->get('flash')->addMessage('error', 'Successfully generated reply message... Try again?');
        }

        return $response->withStatus(302)->withHeader('Location', '/usedReplies');
    }

    /*
     * Read View
     */
    public function show($request, $response, $id)
    {
        $view = 'usedReplies\show.twig';
        $usedReplies = Models\UsedReplies::select('used_replies.id', 'used_replies.reply_id', 'used_replies.created_at', 'platforms.name as platform_name', 'games.name as game_name', 'review_categories.name as review_categories_name', 'replies.text as reply_text')
                                         ->leftJoin('platform_used_replies', 'platform_used_replies.used_reply_id', '=', 'used_replies.id')
                                         ->leftJoin('platforms', 'platforms.id', '=', 'platform_used_replies.platform_id')
                                         ->leftJoin('game_used_replies', 'game_used_replies.used_reply_id', '=', 'used_replies.id')
                                         ->leftJoin('games', 'games.id', '=', 'game_used_replies.game_id')
                                         ->leftJoin('review_category_used_replies', 'review_category_used_replies.used_reply_id', '=', 'used_replies.id')
                                         ->leftJoin('review_categories', 'review_categories.id', '=', 'review_category_used_replies.review_category_id')
                                         ->leftJoin('replies', 'replies.id', '=', 'used_replies.reply_id')
                                         ->where('used_replies.id', '=', $id)->get();
        
        return $this->container->get('view')->render($response, $view, ['usedReplies' => $usedReplies]);
    }
    

    /*
     * Return games associated to a supplied platform ID
     */
    public function getGamesByPlatform($request, $response, $id)
    {
        $games = Models\GamePlatforms::select('games.id', 'games.name')
                              ->leftJoin('games', 'games.id', '=', 'game_platforms.game_id')
                              ->where('game_platforms.platform_id', '=', $id)->get()->toArray();

        $response->getBody()->write(json_encode($games));
        return $response;
    }

    /*
     * Where the magic happens - returns a reply
     */
    public function generateReply($request, $response, $previous_reply_id = null)
    {
        //get posted data
        $posted_data = $request->getParsedBody();
        $platform_id = $posted_data['platform_id'];
        $game_id = $posted_data['game_id'];
        $review_category_id = $posted_data['review_category_id'];

        //reply we're generating
        $reply = null;

        //get most recently used reply id by supplied parameters
        $most_recent_used_reply_id = ($previous_reply_id == null) ? $this->getMostRecentUsedReplyID($platform_id, $game_id, $review_category_id) : $previous_reply_id;

        //if a result was returned, get the next reply to use 
        if ($most_recent_used_reply_id != null) {
            $reply = $this->getNextReplyToUse($most_recent_used_reply_id, $review_category_id);
        }

        //if no reply was returned, return the first reply by the specified category
        if ($reply == null) {
            $reply = $this->getFirstReplyByCategory($review_category_id);
        }

        $response->getBody()->write(json_encode($reply));
        return $response;
    }

    protected function getMostRecentUsedReplyID($platform_id, $game_id, $review_category_id) {
        $most_recent_used_reply_id = Models\UsedReplies::select('used_replies.reply_id')
                                                       ->leftJoin('platform_used_replies', 'platform_used_replies.used_reply_id', '=', 'used_replies.id')
                                                       ->leftJoin('game_used_replies', 'game_used_replies.used_reply_id', '=', 'used_replies.id')
                                                       ->leftJoin('review_category_used_replies', 'review_category_used_replies.used_reply_id', '=', 'used_replies.id')
                                                       ->where('platform_used_replies.platform_id', '=', $platform_id)
                                                       ->where('game_used_replies.game_id', '=', $game_id)
                                                       ->where('review_category_used_replies.review_category_id', '=', $review_category_id)->latest("used_replies.created_at")->first();
        if (isset($most_recent_used_reply_id['reply_id'])) {
            return (int) $most_recent_used_reply_id['reply_id'];
        }
        return null;
    }

    protected function getNextReplyToUse($most_recent_used_reply_id, $review_category_id) {
        $reply = Models\Replies::select('replies.id', 'replies.text')
                               ->leftJoin('reply_review_categories', 'reply_review_categories.reply_id', '=', 'replies.id')
                               ->where('reply_review_categories.review_category_id', '=', $review_category_id)
                               ->where('replies.id', '>', $most_recent_used_reply_id)->first();

        return $reply;
    }

    protected function getFirstReplyByCategory($review_category_id)
    {
        $reply = Models\Replies::select('replies.id', 'replies.text')
                               ->leftJoin('reply_review_categories', 'reply_review_categories.reply_id', '=', 'replies.id')
                               ->where('reply_review_categories.review_category_id', '=', $review_category_id)
                               ->oldest("replies.created_at")->first();

        return $reply;
    }

    /*
     * Delete Endpoint
     */
    public function destroy($request, $response, $id)
    {
        $used_reply = Models\UsedReplies::find($id);
        
        if ($used_reply != null) {
            $used_reply->delete();
            $this->container->get('flash')->addMessage('success', 'Successfully deleted generated reply data!');
        } else {
            $this->container->get('flash')->addMessage('error', 'Successfully deleted generated reply data... Try again?');
        }

        return $response->withStatus(302)->withHeader('Location', '/usedReplies');
    }
}

























/*
select min(reply_review_categories.reply_id) from reply_review_categories where reply_review_categories.review_category_id = $review_category_id;
 */

/*
SELECT MAX(used_replies.reply_id)
FROM used_replies
LEFT JOIN platform_used_replies ON platform_used_replies.used_reply_id = used_replies.reply_id
LEFT JOIN game_used_replies ON game_used_replies.used_reply_id = used_replies.reply_id
LEFT JOIN review_category_used_replies ON review_category_used_replies.used_reply_id = used_replies.reply_id
WHERE platform_used_replies.platform_id = 1
AND game_used_replies.game_id = 1
AND review_category_used_replies.review_category_id = 1;
*/

    /*
    1. Select Platform
    2. Select Game
    3. Select Category
    4. Click Generate
    5. Click Confirm, or click get another reply
    */
    /*
            SELECT used_replies.reply_id, platforms.name, games.name, review_categories.name, replies.text
            FROM used_replies

            LEFT JOIN platform_used_replies on platform_used_replies.used_reply_id = used_replies.reply_id
            LEFT JOIN platforms on platforms.id = platform_used_replies.platform_id


            LEFT JOIN game_used_replies on game_used_replies.used_reply_id = used_replies.reply_id
            LEFT JOIN games on games.id = game_used_replies.game_id

            LEFT JOIN review_category_used_replies on review_category_used_replies.used_reply_id = used_replies.reply_id
            LEFT JOIN review_categories on review_categories.id = review_category_used_replies.review_category_id

            LEFT JOIN replies on replies.id = used_replies.reply_id;  
        */