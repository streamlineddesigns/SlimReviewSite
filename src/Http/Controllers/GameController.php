<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Games;
use App\Models\Platforms;
use App\Models\GamePlatforms;

class GameController extends Controller
{
    /*
     * Index View
     */
    public function index($request, $response)
    {
        $view = 'games\index.twig';
        $games = Games::all();
        return $this->container->get('view')->render($response, $view, ['games' => $games]);
    }

    /*
     * Create View
     */
    public function create($request, $response)
    {
        $view = 'games\create.twig';
        $platforms = Platforms::all();
        return $this->container->get('view')->render($response, $view, ['platforms' => $platforms]);
    }

    /*
     * Create Endpoint
     */
    public function store($request, $response)
    {
        $form_data = $request->getParsedBody();
        $platforms = explode(",", $form_data['platforms']);

        $game = Games::create([
            "name" => $form_data['name'],
        ]);

        if ($game->id != null) {

            if ($platforms[0] != null) {
                for ($i=0; $i < count($platforms); $i++) {
                    $platform_id = $platforms[$i];
                    $game_platform = GamePlatforms::create([
                        "game_id" => $game->id,
                        "platform_id" => $platform_id
                    ]);
                }
            }

            $this->container->get('flash')->addMessage('success', 'Successfully created game!');
        } else {
            $this->container->get('flash')->addMessage('error', 'Failed to create game... Try again?');
        }

        return $response->withStatus(302)->withHeader('Location', '/games');
    }

    /*
     * Read View
     */
    public function show($request, $response, $id)
    {
        $view = 'games\show.twig';
        $game = Games::where('id', $id)->get();
        $platforms = Platforms::all();
        $game_platforms_ids = $this->getGamePlatformsIDS($id);

        return $this->container->get('view')->render($response, $view, ['game' => $game, 'platforms' => $platforms, 'game_platforms' => $game_platforms_ids]);
    }

    /*
     * Update View
     */
    public function edit($request, $response, $id)
    {
        $view = '\games\edit.twig';
        $game = Games::where('id', $id)->get();
        $platforms = Platforms::all();
        $game_platforms_ids = $this->getGamePlatformsIDS($id);

        return $this->container->get('view')->render($response, $view, ['game' => $game, 'platforms' => $platforms, 'game_platforms' => $game_platforms_ids]);
    }

    /*
     * Update Endpoint
     */
    public function update($request, $response, $id)
    {
        $form_data = $request->getParsedBody();
        $new_platform_ids = explode(",", $form_data['platforms']);
        $game = Games::find($id);

        if ($game != null) {
            $game->name = $form_data['name'];
            $game->save();

            $old_platforms_ids = $this->getGamePlatformsIDS($id);

            if (count($new_platform_ids) > 0 && $new_platform_ids[0] != "") {

                for ($n=0; $n < count($new_platform_ids); $n++) {
                    if (! in_array($new_platform_ids[$n], $old_platforms_ids)) {
                        $game_platform = GamePlatforms::create([
                            "game_id" => $game->id,
                            "platform_id" => $new_platform_ids[$n]
                        ]);
                    }
                }
    
                for ($o=0; $o < count($old_platforms_ids); $o++) {
                    if (! in_array($old_platforms_ids[$o], $new_platform_ids)) {
                        $game_platform_to_delete = GamePlatforms::where('game_id', $id)->where('platform_id', $old_platforms_ids[$o]);
                        if ($game_platform_to_delete != null) {
                            $game_platform_to_delete->delete();
                        }
                    }
                }                
            
            } else {
                $game_platforms_to_delete = GamePlatforms::where('game_id', $id);
                if ($game_platforms_to_delete != null) {
                    $game_platforms_to_delete->delete();
                }
            }


            $this->container->get('flash')->addMessage('success', 'Successfully updated game!');
        } else {
            $this->container->get('flash')->addMessage('error', 'Failed to update game... Try again?');
        }

        return $response->withStatus(302)->withHeader('Location', '/games');
    }

    /*
     * Delete Endpoint
     */
    public function destroy($request, $response, $id)
    {
        $game = Games::find($id);
        
        if ($game != null) {
            $game->delete();
            $this->container->get('flash')->addMessage('success', 'Successfully deleted game!');
        } else {
            $this->container->get('flash')->addMessage('error', 'Failed to delete game... Try again?');
        }

        return $response->withStatus(302)->withHeader('Location', '/games');
    }

    protected function getGamePlatformsIDS($id)
    {
        $game_platforms = GamePlatforms::select('game_platforms.platform_id')->leftJoin('platforms', 'platforms.id', '=', 'game_platforms.platform_id')->where('game_id', $id)->get()->toArray();

        $game_platforms_ids = array();

        for($i = 0; $i < count($game_platforms); $i++) {
            array_push($game_platforms_ids, $game_platforms[$i]["platform_id"]);
        }

        return $game_platforms_ids;
    }
}