<?php

class TemplateBlockTypeLinkTableSeeder extends Seeder {

    public function run()
    {
        DB::table('template_block_type_links')->delete();

        TemplateBlockTypeLink::create(array(
                'type'      => 1,
                'template'  => 1
            ));

        TemplateBlockTypeLink::create(array(
                'type'      => 2,
                'template'  => 1
            ));
    }
}
