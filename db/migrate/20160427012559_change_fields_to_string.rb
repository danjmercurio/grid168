class ChangeFieldsToString < ActiveRecord::Migration
  def change
    change_column :offers, :halfHourRate, :string
    change_column :offers, :mvpdSubscriberRate, :string
    change_column :offers, :mvpdOtaSubRate, :string
  end
end
#
# BAD:
# halfHourRate: #<BigDecimal:372b278,'0.0',9(27)>,
#     mvpdSubscriberRate: #<BigDecimal:378fa70,'0.0',9(27)>,
#     mvpdOtaSubRate: #<BigDecimal:3764550,'0.0',9(27)>,
