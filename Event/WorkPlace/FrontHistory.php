<?php


namespace Plugin\Point\Event\WorkPlace;

use Eccube\Event\EventArgs;
use Eccube\Event\TemplateEvent;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * フックポイント汎用処理具象クラス
 *  - 拡張元 : マイページ履歴表示
 *  - 拡張項目 : 画面表示
 * Class FrontHistory
 * @package Plugin\Point\Event\WorkPlace
 */
class FrontHistory extends AbstractWorkPlace
{
    /**
     * 履歴情報挿入
     * @param TemplateEvent $event
     * @return bool
     */
    public function createTwig(TemplateEvent $event)
    {
        // 必要情報の取得と判定
        $parameters = $event->getParameters();
        if (!isset($parameters['Order']) || empty($parameters['Order'])) {
            return false;
        }

        if (is_null($parameters['Order']->getCustomer())) {
            return false;
        }

        // ポイント計算ヘルパーを取得
        $calculator = null;
        $calculator = $this->app['eccube.plugin.point.calculate.helper.factory'];

        // ヘルパーの取得判定
        if (empty($calculator)) {
            return false;
        }

        // 利用ポイントの取得と設定
        $usePoint = $this->app['eccube.plugin.point.repository.point']->getLastAdjustUsePoint($parameters['Order']);

        // 計算に必要なエンティティを登録
        $calculator->addEntity('Order', $parameters['Order']);
        $calculator->addEntity('Customer', $parameters['Order']->getCustomer());
        $calculator->setUsePoint($usePoint);

        // 付与ポイント取得
        $addPoint = $calculator->getAddPointByOrder();

        // 付与ポイント取得判定
        if (empty($addPoint)) {
            $addPoint = 0;
        }

        // ポイント表示用変数作成
        $point = array();

        // エラー判定
        // false が返却された際は、利用ポイント値が保有ポイント値を超えている
        $point['add'] = $addPoint;

        // Twigデータ内IDをキーに表示項目を追加
        // ポイント情報表示
        // false が返却された際は、利用ポイント値が保有ポイント値を超えている
        $point['use'] = $usePoint;
        $snippet = $this->app->render(
            'Point/Resource/template/default/Event/History/point_summary.twig',
            array(
                'point' => $point,
            )
        )->getContent();


        $search = '<p id="summary_box__payment_total"';
        $this->replaceView($event, $snippet, $search);

    }
}
