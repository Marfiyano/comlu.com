<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'Report';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
							'id' => 'report-form',
								'options' => ['class' => 'form-vertical'],
								'fieldConfig' => [
									'template' => "{label}\n<div class=\"col-lg-2 col-xs-3\">{input}</div>",
									'labelOptions' => ['class' => 'col-lg-2 control-label'],
								],
							]); ?>
	
	<?= $form->field($model, 'month')->dropDownList( 
										$month_list,
										['prompt'=>'Pilih Bulan']
									)->label(false); ?>
	
	<?= $form->field($model, 'year')->dropDownList( 
										[
											'2016' => '2016',
											'2017' => '2017',
										],
										['prompt'=>'Pilih Tahun']
									)->label(false); ?>
									
	<div class="controls col-lg-offset-2">
		<?= Html::submitButton('Lihat Report', ['class' =>'btn btn-success']) ?>
	</div>
		
<?php ActiveForm::end(); ?>

<div class="report-index">
	<div id="container" style="width: 100%; height: 500px"></div>
</div>
<script type="text/javascript">
	$(function () {
		/**
		 * Highcharts X-range series plugin
		 */
		(function (H) {
			var defaultPlotOptions = H.getOptions().plotOptions,
				columnType = H.seriesTypes.column,
				each = H.each,
				extendClass = H.extendClass,
				pick = H.pick,
				Point = H.Point;

			defaultPlotOptions.xrange = H.merge(defaultPlotOptions.column, {
				tooltip: {
					pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.yCategory}</b><br/>'
				}
			});
			
			H.seriesTypes.xrange = H.extendClass(columnType, {
				pointClass: extendClass(Point, {
					// Add x2 and yCategory to the available properties for tooltip formats
					getLabelConfig: function () {
						var cfg = Point.prototype.getLabelConfig.call(this);

						cfg.x2 = this.x2;
						cfg.yCategory = this.yCategory = this.series.yAxis.categories && this.series.yAxis.categories[this.y];
						return cfg;
					}
				}),
				type: 'xrange',
				forceDL: true,
				parallelArrays: ['x', 'x2', 'y'],
				requireSorting: false,
				animate: H.seriesTypes.line.prototype.animate,

				/**
				 * Borrow the column series metrics, but with swapped axes. This gives free access
				 * to features like groupPadding, grouping, pointWidth etc.
				 */
				getColumnMetrics: function () {
					var metrics,
						chart = this.chart;

					function swapAxes() {
						each(chart.series, function (s) {
							var xAxis = s.xAxis;
							s.xAxis = s.yAxis;
							s.yAxis = xAxis;
						});
					}

					swapAxes();

					this.yAxis.closestPointRange = 1;
					metrics = columnType.prototype.getColumnMetrics.call(this);

					swapAxes();

					return metrics;
				},
				translate: function () {
					columnType.prototype.translate.apply(this, arguments);
					var series = this,
						xAxis = series.xAxis,
						metrics = series.columnMetrics,
						minPointLength = series.options.minPointLength || 0;

					H.each(series.points, function (point) {
						var barWidth = Math.min(
								xAxis.translate(H.pick(point.x2, point.x + (point.len || 0))) - point.plotX,
								xAxis.len
							),
							barWidthDifference = barWidth < minPointLength ? minPointLength - barWidth : 0;

						point.shapeArgs = {
							x: Math.max(0, point.plotX) - barWidthDifference / 2,
							y: point.plotY + metrics.offset,
							width: barWidth + barWidthDifference,
							height: metrics.width
						};
						point.tooltipPos[0] += barWidth / 2;
						point.tooltipPos[1] -= metrics.width / 2;
					});
				}
			});

			/**
			 * Max x2 should be considered in xAxis extremes
			 */
			H.wrap(H.Axis.prototype, 'getSeriesExtremes', function (proceed) {
				var axis = this,
					dataMax,
					modMax;

				proceed.call(this);
				if (this.isXAxis) {
					dataMax = pick(axis.dataMax, Number.MIN_VALUE);
					each(this.series, function (series) {
						each(series.x2Data || [], function (val) {
							if (val > dataMax) {
								dataMax = val;
								modMax = true;
							}
						});
					});
					if (modMax) {
						axis.dataMax = dataMax;
					}
				}
			});
		}(Highcharts));


		// THE CHART
		$('#container').highcharts({
			chart: {
				type: 'xrange'
			},
			title: {
				text: 'Report Order'
			},
			subtitle: {
				 text: '<?= $month_list[$model->month]. ' ' .$model->year ?>'
			},
			xAxis: {
				type: 'datetime'
			},
			yAxis: {
				title: '',
				categories: [<?php echo join($company_name,','); ?>],
				reversed: true
			},
			plotOptions: {
				series: {
					enableMouseTracking: false
				}
			},
			series: [{
				name: 'Tanggal Order',
				borderRadius: 5,
				pointWidth: 10,
				data: [
				<?php if($data != '') {
						for($g=0;$g<count($data);$g++) {
							for($m=0;$m<count($data[$g]);$m++) {
								echo '{' .join($data[$g][$m],','). '},';
							}
						}
					}?>
				]
			}],
			credits: {
				enabled: false
			}
		});
	});
</script>