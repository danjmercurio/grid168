class AddTotalsToOffer < ActiveRecord::Migration
  def change
    add_column :offers, :runningAudienceTotal, :string
    add_column :offers, :runningHoursTotal, :string
    add_column :offers, :runningWeeklyRateTotal, :string
  end
end
