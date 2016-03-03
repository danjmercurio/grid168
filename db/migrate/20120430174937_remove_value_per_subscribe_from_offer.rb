class RemoveValuePerSubscribeFromOffer < ActiveRecord::Migration
  def up
  	remove_column :offers, :value_per_subscribe
  end

  def down
  end
end
