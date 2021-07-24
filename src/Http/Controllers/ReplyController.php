<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Replies;
use App\Models\ReviewCategories;
use App\Models\ReplyReviewCategories;

class ReplyController extends Controller
{
    /*
     * Index View
     */
    public function index($request, $response)
    {
        $view = 'replies\index.twig';
        $replies = Replies::orderByDesc('id')->get();
        $reply_review_categories = ReplyReviewCategories::select('reply_review_categories.reply_id', 'review_categories.name')->leftJoin('review_categories', 'review_categories.id', '=', 'reply_review_categories.review_category_id')->get()->toArray();
        
        $sorted_reply_review_categories = array();

        for($i = 0; $i < count($reply_review_categories); $i++) {
            
            $key = $reply_review_categories[$i]['reply_id'];
            if (! isset($sorted_reply_review_categories[$key])) {
                $sorted_reply_review_categories[$key] = array();
            }
            array_push($sorted_reply_review_categories[$key], $reply_review_categories[$i]['name']);
        }

        return $this->container->get('view')->render($response, $view, ['replies' => $replies, 'reply_review_categories' => $sorted_reply_review_categories]);
    }

    /*
     * Create View
     */
    public function create($request, $response)
    {
        $view = 'replies\create.twig';
        $reviewCategories = ReviewCategories::all();
        return $this->container->get('view')->render($response, $view, ['reviewCategories' => $reviewCategories]);
    }

    /*
     * Create Endpoint
     */
    public function store($request, $response)
    {
        $form_data = $request->getParsedBody();
        $reviewCategories = explode(",", $form_data['reviewCategories']);

        $reply = Replies::create([
            "text" => $form_data['text'],
        ]);

        if ($reply->id != null) {

            if ($reviewCategories[0] != null) {
                for ($i=0; $i < count($reviewCategories); $i++) {
                    $review_category_id = $reviewCategories[$i];
                    $reply_review_category = ReplyReviewCategories::create([
                        "reply_id" => $reply->id,
                        "review_category_id" => $review_category_id
                    ]);
                }
            }

            $this->container->get('flash')->addMessage('success', 'Successfully created reply!');
        } else {
            $this->container->get('flash')->addMessage('error', 'Failed to create reply... Try again?');
        }

        return $response->withStatus(302)->withHeader('Location', '/replies');
    }

    /*
     * Read View
     */
    public function show($request, $response, $id)
    {
        $view = 'replies\show.twig';
        $reply = Replies::where('id', $id)->get();
        $reviewCategories = ReviewCategories::all();
        $reply_review_categories_ids = $this->getReplyReviewCategoriesIDS($id);

        return $this->container->get('view')->render($response, $view, ['reply' => $reply, 'reviewCategories' => $reviewCategories, 'reply_review_categories' => $reply_review_categories_ids]);
    }

    /*
     * Update View
     */
    public function edit($request, $response, $id)
    {
        $view = '\replies\edit.twig';
        $reply = Replies::where('id', $id)->get();
        $reviewCategories = ReviewCategories::all();
        $reply_review_categories_ids = $this->getReplyReviewCategoriesIDS($id);

        return $this->container->get('view')->render($response, $view, ['reply' => $reply, 'reviewCategories' => $reviewCategories, 'reply_review_categories' => $reply_review_categories_ids]);
    }

    /*
     * Update Endpoint
     */
    public function update($request, $response, $id)
    {
        $form_data = $request->getParsedBody();
        $new_reviewCategory_ids = explode(",", $form_data['reviewCategories']);
        $reply = Replies::find($id);

        if ($reply != null) {
            $reply->text = $form_data['text'];
            $reply->save();

            $old_reviewCategory_ids = $this->getReplyReviewCategoriesIDS($id);

            if (count($new_reviewCategory_ids) > 0 && $new_reviewCategory_ids[0] != "") {

                for ($n=0; $n < count($new_reviewCategory_ids); $n++) {
                    if (! in_array($new_reviewCategory_ids[$n], $old_reviewCategory_ids)) {
                        $reply_review_category = ReplyReviewCategories::create([
                            "reply_id" => $reply->id,
                            "review_category_id" => $new_reviewCategory_ids[$n]
                        ]);
                    }
                }
    
                for ($o=0; $o < count($old_reviewCategory_ids); $o++) {
                    if (! in_array($old_reviewCategory_ids[$o], $new_reviewCategory_ids)) {
                        $reply_review_category_to_delete = ReplyReviewCategories::where('reply_id', $id)->where('review_category_id', $old_reviewCategory_ids[$o]);
                        if ($reply_review_category_to_delete != null) {
                            $reply_review_category_to_delete->delete();
                        }
                    }
                }                
            
            } else {
                $reply_review_categories_to_delete = ReplyReviewCategories::where('reply_id', $id);
                if ($reply_review_categories_to_delete != null) {
                    $reply_review_categories_to_delete->delete();
                }
            }


            $this->container->get('flash')->addMessage('success', 'Successfully updated reply!');
        } else {
            $this->container->get('flash')->addMessage('error', 'Failed to update reply... Try again?');
        }

        return $response->withStatus(302)->withHeader('Location', '/replies');
    }

    /*
     * Delete Endpoint
     */
    public function destroy($request, $response, $id)
    {
        $reply = Replies::find($id);
        
        if ($reply != null) {
            $reply->delete();
            $this->container->get('flash')->addMessage('success', 'Successfully deleted reply!');
        } else {
            $this->container->get('flash')->addMessage('error', 'Failed to delete reply... Try again?');
        }

        return $response->withStatus(302)->withHeader('Location', '/replies');
    }

    protected function getReplyReviewCategoriesIDS($id)
    {
        $reply_review_categories = ReplyReviewCategories::select('reply_review_categories.review_category_id')->leftJoin('review_categories', 'review_categories.id', '=', 'reply_review_categories.review_category_id')->where('reply_id', $id)->get()->toArray();

        $reply_review_categories_ids = array();

        for($i = 0; $i < count($reply_review_categories); $i++) {
            array_push($reply_review_categories_ids, $reply_review_categories[$i]["review_category_id"]);
        }

        return $reply_review_categories_ids;
    }
}