<?php

declare(strict_types=1);

use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Http\Controllers;

return function (App $app) {
    /* Platforms routes */
    $app->group('/platforms', function (Group $group) {
        $group->get('', [Controllers\PlatformController::class, 'index']);
        $group->get('/create', [Controllers\PlatformController::class, 'create']);
        $group->post('', [Controllers\PlatformController::class, 'store']);
        $group->get('/{id}', [Controllers\PlatformController::class, 'show']);
        $group->get('/{id}/edit', [Controllers\PlatformController::class, 'edit']);
        $group->post('/{id}', [Controllers\PlatformController::class, 'update']);
        $group->post('/{id}/delete', [Controllers\PlatformController::class, 'destroy']);
    });

    /* Games routes */
    $app->group('/games', function (Group $group) {
        $group->get('', [Controllers\GameController::class, 'index']);
        $group->get('/create', [Controllers\GameController::class, 'create']);
        $group->post('', [Controllers\GameController::class, 'store']);
        $group->get('/{id}', [Controllers\GameController::class, 'show']);
        $group->get('/{id}/edit', [Controllers\GameController::class, 'edit']);
        $group->post('/{id}', [Controllers\GameController::class, 'update']);
        $group->post('/{id}/delete', [Controllers\GameController::class, 'destroy']);
    });

    /* Review Categories routes */
    $app->group('/reviewCategories', function (Group $group) {
        $group->get('', [Controllers\ReviewCategoryController::class, 'index']);
        $group->get('/create', [Controllers\ReviewCategoryController::class, 'create']);
        $group->post('', [Controllers\ReviewCategoryController::class, 'store']);
        $group->get('/{id}', [Controllers\ReviewCategoryController::class, 'show']);
        $group->get('/{id}/edit', [Controllers\ReviewCategoryController::class, 'edit']);
        $group->post('/{id}', [Controllers\ReviewCategoryController::class, 'update']);
        $group->post('/{id}/delete', [Controllers\ReviewCategoryController::class, 'destroy']);
    });

    /* Replies routes */
    $app->group('/replies', function (Group $group) {
        $group->get('', [Controllers\ReplyController::class, 'index']);
        $group->get('/create', [Controllers\ReplyController::class, 'create']);
        $group->post('', [Controllers\ReplyController::class, 'store']);
        $group->get('/{id}', [Controllers\ReplyController::class, 'show']);
        $group->get('/{id}/edit', [Controllers\ReplyController::class, 'edit']);
        $group->post('/{id}', [Controllers\ReplyController::class, 'update']);
        $group->post('/{id}/delete', [Controllers\ReplyController::class, 'destroy']);
    });

    /* Generate routes */
    $app->group('/usedReplies', function (Group $group) {
        $group->get('', [Controllers\UsedRepliesController::class, 'index']);
        $group->get('/create', [Controllers\UsedRepliesController::class, 'create']);
        $group->post('', [Controllers\UsedRepliesController::class, 'store']);
        $group->get('/{id}', [Controllers\UsedRepliesController::class, 'show']);
        $group->post('/{id}/delete', [Controllers\UsedRepliesController::class, 'destroy']);

        $group->get('/getGamesByPlatform/{id}', [Controllers\UsedRepliesController::class, 'getGamesByPlatform']);
        $group->post('/generateReply', [Controllers\UsedRepliesController::class, 'generateReply']);
        $group->post('/generateReply/{previous_reply_id}', [Controllers\UsedRepliesController::class, 'generateReply']);
    });
};