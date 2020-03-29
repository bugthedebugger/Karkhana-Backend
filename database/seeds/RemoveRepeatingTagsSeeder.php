<?php

use Illuminate\Database\Seeder;
use App\Model\Tag;
use App\Model\TagTranslation;

class RemoveRepeatingTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagTranslationGroups = TagTranslation::groupBy('name')->get();
        $names = null;
        foreach($tagTranslationGroups as $tagTranslationGroup) {
            $names[] = $tagTranslationGroup->name;
        }

        foreach($names as $name) {
            $tagTranslations = TagTranslation::where('name', $name)->orderBy('id', 'desc')->get();
            $tagCount = $tagTranslations->count();
            if ( $tagCount > 1) {
                foreach($tagTranslations as $tagTranslation) {
                    $tag = Tag::find($tagTranslation->tag_id);
                    $tag->blogs()->detach();
                    $tag->delete();
                    $tagCount--;
                    if ($tagCount == 1)
                        break;
                }
            }
        }
    }
}
