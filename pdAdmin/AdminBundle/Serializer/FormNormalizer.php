<?php

/**
 * This file is part of the pdAdmin package.
 *
 * (c) pdAdmin <http://pdadmin.net/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AdminBundle\Serializer;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\Form;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * pdAdmin Class Form Normalizer
 *
 * @package AdminBundle\Normalizer
 * @author  Ramazan Apaydın <iletisim@ramazanapaydin.com>
 */
class FormNormalizer implements NormalizerInterface
{
    private $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function normalize($object, $format = null, array $context = array())
    {
        return $this->formNormalize($object);
    }

    private function formNormalize(Form $ob)
    {
        $items = [];
        $translated = ['label', 'infoText', 'infoConst'];

        foreach ($ob->createView() as $itemName => $itemView) {
            $items[$itemName] = [];
            if ($itemView->count()) {
                $this::iterator($items, $translated, $itemName, $itemView);
            } else {
                foreach ($itemView->vars as $k => $v) {
                    if (!is_object($v)) {
                        if (is_array($v)) {
                            foreach ($v as $vk => $vv) {
                                if ($vv instanceof ChoiceView) {
                                    $items[$itemName][$k][$vv->data] = $itemView->vars['choice_translation_domain'] != false ? $this->translator->trans($vv->label, [], $itemView->vars['translation_domain']) : $vv->label;
                                } else {
                                    $items[$itemName][$k][$vk] = in_array($vk, $translated) ? $this->translator->trans($vv, [], $itemView->vars['translation_domain']) : $vv;
                                }
                            }
                        } else {
                            $items[$itemName][$k] = in_array($k, $translated) ? $this->translator->trans($v, [], $itemView->vars['translation_domain']) : $v;
                        }
                    }
                    if ($k == 'errors')
                        $items[$itemName][$k] = $v->__toString();
                }
            }
        }

        return $items;
    }

    private function iterator(&$items, $translated,  $itemName, $itemView)
    {
        foreach ($itemView as $childKey => $childVal) {
            if (!$childVal->count()) {
                foreach ($childVal->vars as $k => $v) {
                    if (!is_object($v))
                        $items[$itemName][$childKey][$k] = in_array($k, $translated) ? $this->translator->trans($v, [], $childVal->vars['translation_domain']) : $v;
                    if ($k == 'errors')
                        $items[$itemName][$childKey][$k] = in_array($k, $translated) ? $this->translator->trans($v->__toString(), [], $childVal->vars['translation_domain']) : $v->__toString();
                }
            } else {
                $this::iterator($childKey, $childVal);
            }
        }
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Form;
    }
}