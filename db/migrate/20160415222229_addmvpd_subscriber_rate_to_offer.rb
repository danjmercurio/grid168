class AddmvpdSubscriberRateToOffer < ActiveRecord::Migration
  def change
    add_column :offers, :mvpdSubscriberRate, :decimal
  end
end
