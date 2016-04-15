class AddmvpdOtaSubRateToOffer < ActiveRecord::Migration
  def change
    add_column :offers, :mvpdOtaSubRate, :decimal
  end
end
