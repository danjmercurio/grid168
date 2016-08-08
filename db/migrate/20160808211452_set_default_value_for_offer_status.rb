class SetDefaultValueForOfferStatus < ActiveRecord::Migration
  def change
    change_column :offers, :status, :string, :default => 'Open'
  end
end
