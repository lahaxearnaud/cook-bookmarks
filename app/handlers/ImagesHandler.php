<?php
use Illuminate\Queue\Jobs\Job;
use Intervention\Image\ImageManagerStatic as Image;

class ImagesHandler
{
    public function fire(Job $job, $data)
    {
        echo 'handler...' . $data['id'] . "\n";
        if ($job->attempts() > 3) {
            Log::error('Fail to handle job ' . $job->getJobId() . ' ' . print_r($data, true));
            $job->delete();

            return;
        }

        $article = Article::findOrFail($data['id']);
        Image::configure(array('driver' => 'imagick'));

        $publicPath = public_path('i/' . $data['id']);

        $original = Image::make($publicPath . '/original.png');

        $image = $original;
        $image->resize(200, 200);
        $image->save($publicPath . '/200x200.png');

        $image = $original;
        $image->resize(200, 200);
        $image->save($publicPath . '/100x100.png');

        $image = $original;
        $image->resize(200, 200);
        $image->save($publicPath . '/150x150.png');

        $image = $original;
        $image->resize(32, 32);
        $image->save($publicPath . '/32x32.png');

        $article->image          = asset('i/' . $data['id'] . '/200x200.png');
        $article->imageMiniature = asset('i/' . $data['id'] . '/32x32.png');
        $article->updateUniques();

        $job->delete();
    }
}
