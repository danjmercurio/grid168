class AddHalfHourRateToOffer < ActiveRecord::Migration
  def change
    add_column :offers, :halfHourRate, :decimal
  end
end
