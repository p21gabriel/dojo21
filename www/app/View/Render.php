<?php

namespace App\View;

class Render
{
    /**
     * @var string
     */
    private string $filePath;

    /**
     * @param string $rootDirectory
     */
    public function __construct(
        private string $rootDirectory
    ) {
    }

    /**
     * @param $templatePath
     * @param array $variables
     * @return string
     */
    public function render($templatePath, array $variables) : string
    {
        $this->filePath = $this->rootDirectory . '/'. $templatePath;

        $viewContent = $this->getFileContent($this->filePath);

        $viewContent = $this->inheritanceLayout($viewContent);

        $viewContent = $this->functionsCalls($viewContent);

        $viewContent = $this->viewVariables($viewContent);

        return $this->fetch($viewContent, $variables);
    }

    /**
     * @param string $content
     * @param array $variables
     * @return string
     */
    private function fetch(string $content, array $variables): string
    {
        $hashContent = 'view_' . md5($content);

        $content_cache = ROOT_DIR . '/storage/cache/view/' . $hashContent;

        if (!file_exists($content_cache)) {
            file_put_contents($content_cache, $content);
        }

        return $this->renderPartial($content_cache, $variables);
    }

    /**
     * @param string $filePath
     * @return false|string
     */
    private function getFileContent(string $filePath): false|string
    {
        return file_get_contents($filePath);
    }

    /**
     * @param false|string $viewContent
     * @return array|string|string[]
     */
    public function functionsCalls(false|string $viewContent): string|array
    {
        $viewContent = str_replace('{{', "<?= ", $viewContent);
        return str_replace('}}', " ?>", $viewContent);
    }

    /**
     * @param string $viewContent
     * @return string
     */
    public function viewVariables(string $viewContent): string
    {
        $patternVariable = '/<?=\s{1,}VARIABLE_FORM{1,}\s{1,}\?>/m';

        $patternVariableString = str_replace('VARIABLE_FORM', '[a-zA-Z]', $patternVariable);

        preg_match_all($patternVariableString, $viewContent, $a);

        $variablesTemplate = array_map(function ($item) {
            $item = str_replace(['$', '=', '?', '>', '<'], '', $item);

            return '$' . trim($item);
        }, (array) array_values(reset($a)));

        foreach ($variablesTemplate as $variable) {
            $variableSearch = str_replace('$', '', $variable);

            $patternVariableA = str_replace('VARIABLE_FORM', $variableSearch, $patternVariable);

            $viewContent = preg_replace($patternVariableA, "= $variable ?>", $viewContent);
        }

        return $viewContent;
    }

    /**
     * @param string $viewContent
     * @return string
     */
    private function inheritanceLayout(string $viewContent): string
    {
        $patternExtends = "/\{%\s+extends\s+(.*)%\}/";

        preg_match_all($patternExtends, $viewContent, $result);

        if (count($result[0]) < 1 && count($result[1]) < 1) {
            return $viewContent;
        }

        $layout = $result[1][0];

        $layout = str_replace(['"', ' '], '', $layout);

        $requireLayout = $this->rootDirectory . '/' . $layout . '.twig';

        $stringLayout = file_get_contents($requireLayout);


        // get layout required

        $blocksView = $this->getBlocks($viewContent);
        $blocksLayout = $this->getBlocks($stringLayout);

        foreach ($blocksView['blocks_names'] as $block) {
            $block = trim($block);

            $contentBlock = $this->getContentBlock($block, $viewContent);

            $stringLayout = $this->replaceBlockContentLayout($block, $contentBlock, $stringLayout);
        }

        $diffBlocks = array_diff($blocksLayout['blocks_names'], $blocksView['blocks_names']);

        foreach ($diffBlocks as $block) {
            $stringLayout = $this->replaceBlockContentLayout($block, '', $stringLayout);
        }

        return $stringLayout;
    }

    /**
     * @param string $file_path
     * @param array $variables
     * @return string
     */
    public function renderPartial(string $file_path, array $variables = []): string
    {
        ob_start();

        extract($variables);

        (require_once $file_path);
        $view = ob_get_contents();
        ob_flush();

        return $view;
    }

    /**
     * @param string $viewContent
     * @return array
     */
    public function getBlocks(string $viewContent): array
    {
        $patternsBlock = "/\{%\s+block\s+(.*)%\}/";
        preg_match_all($patternsBlock, $viewContent, $blocks);

        $blockNames = [];
        foreach ($blocks[1] as $block) {
            $block = trim($block);

            $position = strpos($block, "%");

            if ($position) {
                $start = $position - 1;

                $block = substr($block, 0, $start);
            }

            $blockNames[] = $block;
        }

        return [
            'blocks_names' => $blockNames,
            'blocks_tags' => $blocks[0]
        ];
    }

    /**
     * @param string $blockName
     * @param string $viewContent
     * @return string
     */
    public function getContentBlock(string $blockName, string $viewContent): string
    {
        $pattern = "/(\{%\s{1,}block\s{1,}NAME_BLOCK)\s{1,}%\}([\s\S]){1,}(\{%\s{1,}endblock\s{1,}NAME_BLOCK\s{1,}%\})/";
        $pattern = str_replace("NAME_BLOCK", $blockName, $pattern);

        preg_match_all($pattern, $viewContent, $blocks);

        if (!count($blocks[0])) {
            return "";
        }

        $contentBlock = $blocks[0][0];

        $pattern = str_replace("NAME_BLOCK", $blockName, "/({%\s{1,}block\s{1,}NAME_BLOCK)\s{1,}\%\}/");
        $contentBlock = preg_replace($pattern, '', $contentBlock);

        $pattern = str_replace("NAME_BLOCK", $blockName, "/({%\s{1,}endblock\s{1,}NAME_BLOCK)\s{1,}\%\}/");
        $contentBlock = preg_replace($pattern, '', $contentBlock);

        return trim($contentBlock);
    }

    /**
     * @param string $block
     * @param string $contentBlock
     * @param string $layout
     * @return array|string|string[]|null
     */
    public function replaceBlockContentLayout(string $block, string $contentBlock, string $layout): string|array|null
    {
        $patternBlock = "/\{\%\s{1,}(block\s{1,}NAME_BLOCK)\s{1,}%\}([\s\S]){1,}(endblock\s{1,}NAME_BLOCK\s{1,}\%\})/";
        $patternBlock = str_replace("NAME_BLOCK", $block, $patternBlock);

        return preg_replace($patternBlock, $contentBlock, $layout);
    }
}