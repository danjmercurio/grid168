class AddDollarAmountEnteredToOffer < ActiveRecord::Migration
  def change
    add_column :offers, :dollar_amount, :float, :null => false, :default => 0
  end
end
