<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Channel;
use App\Models\Newsitem;

class NewsController extends Controller
{
    function read_news($id) {
        return view('readnews', [
            'newsitems' => Newsitem::where('channel_id', '=', $id)->paginate(10),
            'channel_name' => Channel::find($id)->channel_name,
            ] 
        );
    }
    function save_news($id) {
        $channel = Channel::find($id);
        $content = file_get_contents($channel->url);
        $contetn_array = new \SimpleXMLElement($content);

        foreach ($contetn_array->channel->item as $entry) {
            //dd(Newsitem::find(1)->link, $entry->link[0]);
            Newsitem::updateOrCreate(
                ['link' => '$entry->link'],
                [
                    'channel_id' => $channel->id,
                    "title" => $entry->title,
                    "link" => $entry->link,
                    "description" => $entry->description,
                    "img_url" => $entry->enclosure->attributes()->url,
                    "pub_date" => $entry->pubDate,
                ]
            );
        }
        return redirect()->back()->with('successmsg', 'News saved/updated :)');
    }
}
